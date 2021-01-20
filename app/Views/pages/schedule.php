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
        sche.events.add({
          start: args.start,
          end: args.end,
          id: DayPilot.guid(),
          resource: args.resource,
          text: modal.result
        });
      });
    },
    onScroll: function (args){
        DayPilot.Http.ajax({
        url: "backend_events.php?start=" + start.toString() + "&end=" + end.toString(),
        success: function (ajax) {
          args.events = ajax.data;
          args.loaded();
        }
      });
    },
    eventMoveHandling: "Update",
    onEventMoved: function (args) {
      this.message("Event moved: " + args.e.text());
    },
    eventResizeHandling: "Update",
    onEventResized: function (args) {
      this.message("Event resized: " + args.e.text());
    },
    eventDeleteHandling: "Update",
    onEventDeleted: function (args) {
      this.message("Event deleted: " + args.e.text());
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
  sche.resources = [
    {name: "Resource 1", id: "R1"},
    {name: "Resource 2", id: "R2"},
    {name: "Resource 3", id: "R3"},
    {name: "Resource 4", id: "R4"},
    {name: "Resource 5", id: "R5"},
    {name: "Resource 6", id: "R6"},
    {name: "Resource 7", id: "R7"},
    {name: "Resource 8", id: "R8"},
    {name: "Resource 9", id: "R9"},
  ];
  sche.events.list = [];
  sche.init();
</script>
