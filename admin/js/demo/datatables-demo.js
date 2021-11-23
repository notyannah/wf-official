// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#appDataTable').DataTable({"aaSorting": [ [0,'desc'] ]});
  $('#dataTable').DataTable();
});
