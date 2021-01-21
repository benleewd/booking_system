<div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <input type="hidden" id="username" value="<?= session()->get('username') ?>">
        <h1>Hello, <?= session()->get('username')?></h1>
      </div>
    </div>
    <hr>
    <div>
      <div id="sche"></div>
    </div>
</div>
<script>
  var sche = new DayPilot.Scheduler("sche", {
    cellWidthSpec: "Fixed",
    cellWidth: 30,
    timeHeaders: [{"groupBy":"Day","format":"dddd, d MMMM yyyy"},{"groupBy":"Hour"},{"groupBy":"Cell","format":"mm"}],
    scale: "CellDuration",
    cellDuration: 30,
    days: 7,
    startDate: DayPilot.Date.today().firstDayOfWeek(),
    showNonBusiness: false,
    eventHeight: 30,
    timeRangeSelectedHandling: "Enabled",
    treeEnabled: true,
    heightSpec: "Max",
    dynamicLoading: true, 
    dynamicEventRendering: "Disabled",
    onTimeRangeSelected: function (args) {
      var sche = this;
      DayPilot.Modal.prompt("Create a new event:", "Event 1").then(function(modal) {
        sche.clearSelection();
        if (modal.canceled) { return; }
        DayPilot.Http.ajax({
          data: {
            start: args.start.toString(),
            end: args.end.toString(),
          },
          url: "schedule/addSchedule",
          success: function (ajax) {
            var data = ajax.data;
            var e = new DayPilot.Event({
              start: args.start,
              end: args.end,
              id: data.id,
              resource: args.resource,
              text: document.getElementById('username')
            });
            event.add(e);
          }
        })
      });
    },
    onScroll: function (args){
      args.async = true;
      var start = args.viewport.start.addDays(-7);
      var end = args.viewport.end.addDays(7);
      DayPilot.Http.ajax({
        url: "schedule/getAllSchedule",
        success: function (ajax) {
          args.events = ajax.data;
          args.loaded();
      }
    });
    },
    eventMoveHandling: "Update",
    onEventMoved: function (args) {
      DayPilot.Http.ajax({
        url: "schedule/updateSchedule",
        data: {
          id: args.e.id(),
          newStart: args.newStart.toString(),
          newEnd: args.newEnd.toString(),
          newResource: args.newResource
        },
        success: function (ajax) {
          this.message("Moved.");
        }
      });
    },
    eventResizeHandling: "Update",
    onEventResized: function (args) {
      DayPilot.Http.ajax({
        url: "schedule/updateSchedule",
        data: {
          id: args.e.id(),
          newStart: args.newStart.toString(),
          newEnd: args.newEnd.toString()
        },
        success: function (ajax) {
          this.message("Resized.");
        }
      });
    },
    eventDeleteHandling: "Update",
    onEventDeleted: function (args) {
      DayPilot.Http.ajax({
        url: "schedule/deleteSchedule",
        data: {
          id: args.e.id()
        },
        success: function (ajax) {
          this.message("Deleted.");
        }
      });
    },
    eventClickHandling: "Disabled",
    eventHoverHandling: "Bubble",
    bubble: new DayPilot.Bubble({
      onLoad: function(args) {
        // if event object doesn't specify "bubbleHtml" property 
        // this onLoad handler will be called to provide the bubble HTML
        args.html = "Event details";
      }
    }),
    treeEnabled: true,
  });
  
  sche.init();
  sche.scrollTo(DayPilot.Data.today());

  loadResource();

  function loadResource() {
    var resources = [];
    DayPilot.Http.ajax({
      url: "resource/getAllGroups",
      success: function (ajax) {
        var data1 = JSON.parse(ajax.data);
        data1.forEach(group => {
          var gp = {};
          gp.name = group.name;
          gp.id = group.id;
          DayPilot.Http.ajax({
            url: "resource/getAllResource",
            data: {
              id: gp.id
            },
            success: function (ajax2) {
              var data2 = JSON.parse(ajax2.data);
              var children = [];
              data2.forEach(resource => {
                var r = {};
                r.name = resource.name;
                r.id = resource.id;
                children.push(r);
              });
            }
          });
          resources.push(gp);
        });
      }
    });
    sche.rows.load(resources);
  }
</script>
