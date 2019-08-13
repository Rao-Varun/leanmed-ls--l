function action(table,history,cellvalue,action){
		$.ajax({
                type: "POST",
                url: "admin/manageApproval",
                data: {
                	"table": table,
                	"id": cellvalue,
                	"history": history,
                	"action": action},
                dataType: "json",
                success: function(){
                }
            });
	
	$('#approvalsjqGrid').trigger( 'reloadGrid' );

}
$(document).ready(function () {
	$("#usersjqGrid").jqGrid({
		styleUI : 'Bootstrap',
		datatype: 'json',
		mtype: 'GET',
		url : 'admin/users',
		editurl: 'admin/editUser',
		colModel: [
		{ label: 'email Id', name: 'emailId', key: true, editable: true, width: 200,editrules : { required: true},edittype:"text"},
		{ label: 'User Name', name: 'userName', editable: true,editrules : { required: true},edittype:"text"},
		{ label: 'User Type', name: 'userType', formatter: statusFormatter},
		{ label: 'status', name: 'status'}
		],
		viewrecords: true,
		height: 300,
		rowNum: 20,
		loadonce: false,
		multiselect: true,
		width: null,
		shrinkToFit: true,
		pager: "#usersjqGridPager"
	});
	function statusFormatter(cellvalue, options, rowObject){
		   if (cellvalue == 1) 
		   	return 'Admin';
		   else if (cellvalue == 2)
		    return 'User';
	}
	$('#usersjqGrid').navGrid('#usersjqGridPager',
		{ edit: true, add: true, del: true, search: true, refresh: false, view: false, position: "left", cloneToTop: true },
		{
			editCaption: "Edit Record",
			recreateForm: true,
			checkOnUpdate : true,
			checkOnSubmit : true,
			closeAfterEdit: true,
			errorTextFormat: function (data) {
				return 'Error: ' + data.responseText
			}
		},
		{
			closeAfterAdd: true,
			recreateForm: true,
			errorTextFormat: function (data) {
				return 'Error: ' + data.responseText
			}
		},
		{
			errorTextFormat: function (data) {
				return 'Error: ' + data.responseText
			}
		});

	$("#approvalsjqGrid").jqGrid({
		styleUI : 'Bootstrap',
		datatype: 'json',
		mtype: 'GET',
		url : 'admin/approvals',
		colModel: [
		{ label: 'email Id', name: 'userId', key: true},
		{ label: 'Approval', name: 'message'},
		{ label: 'Actions', name: 'storageId', formatter: actionFormatter}],
		viewrecords: true,
		height: 300,
		rowNum: 20,
		loadonce: false,
		width: null,
		shrinkToFit: true,
		pager: "#approvalsjqGridPager"
	});
	
	function actionFormatter(cellvalue, options, rowObject){
		var message = rowObject.message;
		return "<button class='btn btn-success btn-sm actions' onclick=action('"+rowObject.table+"','"+message.replace(/\s+/g,'')+"','"+cellvalue+"','approve')> Approve</button> <button class='btn btn-danger btn-sm actions'  onclick=action('"+rowObject.table+"','"+message.replace(/\s+/g,'')+"','"+cellvalue+"','reject')> Decline</button>";
	}
	
});

