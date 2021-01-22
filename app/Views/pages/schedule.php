<div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <input type="hidden" id="username" value="<?= session()->get('username') ?>">
        <input type="hidden" id="id" value="<?= session()->get('id') ?>">
        <h1>Hello, <?= session()->get('username')?></h1>

      </div>
    </div>
    <hr>
    <div>
      <div id="sche"></div>
    </div>
</div>
<script>
  var userid = document.getElementById('id').value;
  var username = document.getElementById('username').value;
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
    allowEventOverlap: false,
    onTimeRangeSelected: function (args) {
      var sche = this;
      DayPilot.Modal.confirm("Create a new event:").then(function(modal) {
        sche.clearSelection();
        // console.log(args.resource);
        // console.log(args.start.toString());
        // console.log(args.end.toString());
        // console.log(userid);
        var fields = {
            start: args.start.toString(),
            end: args.end.toString(),
            resource: parseInt(args.resource),
            id: parseInt(userid)
          };
        if (modal.canceled) { return; }
        DayPilot.Http.ajax({
          data: fields,
          url: "schedule/addSchedule",
          success: function (ajax) {
            console.log(ajax);
            var data = ajax.data;
            var e = new DayPilot.Event({
              start: args.start,
              end: args.end,
              id: data.id,
              resource: args.resource,
              text: username
            });
            sche.events.add(e);
          },
          error: function (ajax) {
            // console.log(userid);
            // console.log(ajax);
            // console.log(fields);
          }
        })
      });
    },
    onScroll: function (args){
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
        url: "schedule/checkSchedule",
        data: {
          userid: userid,
          id: args.e.id(),
        },
        success: function (ajax) {
          var bool = false;
          if (!ajax.data){
            sche.message('You can only move your own bookings');
          } else {
            DayPilot.Http.ajax({
              url: "schedule/updateSchedule",
              data: {
                id: args.e.id(),
                newStart: args.newStart.toString(),
                newEnd: args.newEnd.toString(),
                newResource: args.newResource
              },
              success: function (ajax) {
                sche.message("Moved.");
              },
              error: function (ajax) {
                  // console.log(args.e.id());
                  // console.log(ajax);
              }
            });
          }
        }
      });
    },
    eventResizeHandling: "Update",
    onEventResized: function (args) {
      DayPilot.Http.ajax({
        url: "schedule/checkSchedule",
        data: {
          userid: userid,
          id: args.e.id(),
        },
        success: function (ajax) {
          var bool = false;
          if (!ajax.data){
            sche.message('You can only resize your own bookings');
          } else {
            DayPilot.Http.ajax({
              url: "schedule/updateSchedule",
              data: {
                id: args.e.id(),
                newStart: args.newStart.toString(),
                newEnd: args.newEnd.toString(),
                newResource: args.e.data.resource
              },
              success: function (ajax) {
                sche.message("Resized.");

              },
              error: function (ajax) {
                  // console.log(args.e.id());
                  // console.log(ajax);
              }
            });
          }
        }
      });
    },
    eventDeleteHandling: "Update",
    onEventDeleted: function (args) {
      DayPilot.Http.ajax({
        url: "schedule/checkSchedule",
        data: {
          userid: userid,
          id: args.e.id(),
        },
        success: function (ajax) {
          var bool = false;
          if (!ajax.data){
            sche.message('You can only delete your own bookings');
          } elseif (confirm("Confirm deletion")) {
            DayPilot.Http.ajax({
              url: "schedule/deleteSchedule",
              data: {
                id: args.e.id()
              },
              success: function (ajax) {
                sche.message("Deleted.");
              },
              error: function (ajax) {
                  // console.log(args.e.id());
                  // console.log(ajax);
              }
            });
          }
        }
      });
    },
    eventClickHandling: "Disabled",
    eventHoverHandling: "Bubble",
    bubble: new DayPilot.Bubble({
      onLoad: function(args) {
        // if event object doesn't specify "bubbleHtml" property 
        // this onLoad handler will be called to provide the bubble HTML
        args.html = "Working!";
      }
    }),
    treeEnabled: true,
    
  });

  sche.init();
  sche.onBeforeEventRender = function(args) {
    if (args.data.text == "admin") {
      args.data.backColor = "#ffebc0";
      args.data.barColor = "Maroon";
    } else {
      args.data.backColor = "Light Gray";

    }
  }
  sche.rows.load("resources/getAllResource")
  sche.rows.expand();

  
</script>
