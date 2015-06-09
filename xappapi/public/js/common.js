msgBoxImagePath = "../../public/img/";

var type;
$(document).ready(function(){
	$(function() {
		$.extend($.tablesorter.themes.bootstrap, {
			table      : 'table table-bordered',
			header     : 'bootstrap-header',
			footerRow  : '',
			footerCells: '',
			icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
			sortNone   : 'bootstrap-icon-unsorted',
			sortAsc    : 'icon-chevron-up',
			sortDesc   : 'icon-chevron-down',
			active     : '',
			hover      : '', 
			filterRow  : '',
			even       : '',
			odd        : ''  
		});
		$("table").tablesorter({
			theme : "bootstrap",
			widthFixed: true,
			headerTemplate : '{content} {icon}',
			widgets : [ "uitheme", "zebra", "filter" ],
			widgetOptions : {
				zebra : ["even", "odd"],
				filter_cssFilter   : 'tablesorter-filter',
				filter_childRows   : false,
				filter_hideFilters : false,
				filter_ignoreCase  : true,
				filter_reset : '.reset',
				filter_searchDelay : 300,
				filter_startsWith  : false,
				filter_hideFilters : false,
				filter_functions : { }
			}
		});
		/*
		$("table").tablesorterPager({
			container: $(".pager"),
			cssGoto  : ".pagenum",
			removeRows: false,
			output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'		
		});
		*/
		//$("#content_2").mCustomScrollbar({set_Height:500px});
	
		$(".datepicker").datepicker({dateFormat:'yy-mm-dd'});
		$(".datetimepicker").datetimepicker({
			dateFormat:'yy-mm-dd', timeFormat: 'HH:mm:ss z', showTimezone: false, useLocalTimezone: false,
			defaultTimezone: '+0000'
		});
		$('#files').change(function(evt) {
			$('#startUploadBtn').trigger('click');
			setTimeout(function(){
				$.post(base_url+"index.php/database/import",{type:type}, 
				function (data){
					if (data == true) {
						$.msgBox({
						 title:"Alert",
						 content:"Successfully imported!"
						});
					}
					else {
						$.msgBox({
						 title:"Alert",
						 content:"Not export. Please try to import again!"
						});
					}
				});
			}, 2000);
			return true;
		});	
	});
});
$(window).resize(function() {
	
}).resize();
(function($){
	   $(window).load(function(){
			$(".mCSB_dragger_bar").attr("style","width: 100%;border-radius: 0px;background-color: #964685;");
	   });
})(jQuery);

function logout(){
	$.post(base_url+"index.php/login/out", {}, function (data){
		document.location.href = base_url+"index.php";
	});
}
function onBroadCast(nId){
	$.post(base_url+"index.php/devices/broadcast", {}, function (data){
		if (data)
			$.msgBox({
				 title:"Alert",
				 content:"Success!"
			});
		else
			$.msgBox({
				 title:"Alert",
				 content:"Failure!"
			});
	});
}
function onUsersDetails(nId){
	document.location.href = base_url+"index.php/users/details?id="+nId;
}
function onOrdersDetails(nId){
	document.location.href = base_url+"index.php/orders/details?id="+nId;
}
function onItemsDetails(nId){
	document.location.href = base_url+"index.php/items/details?id="+nId;
}
function onBarcodesDetails(nId){
	document.location.href = base_url+"index.php/barcodes/details?id="+nId;
}
function onUsersEdit(nId){
	document.location.href = base_url+"index.php/users/edit?id="+nId;
}
function onOrdersEdit(nId){
	document.location.href = base_url+"index.php/orders/edit?id="+nId;
}
function onItemsEdit(nId){
	document.location.href = base_url+"index.php/items/edit?id="+nId;
}
function onBarcodesEdit(nId){
	document.location.href = base_url+"index.php/barcodes/edit?id="+nId;
}
function onEditUsers_Back(){
	document.location.href = base_url+"index.php/users/index";
}
function onEditOrders_Back(){
	document.location.href = base_url+"index.php/orders/index";
}
function onEditItems_Back(){
	document.location.href = base_url+"index.php/items/index";
}
function onEditBarcodes_Back(){
	document.location.href = base_url+"index.php/barcodes/index";
}
function onUsers_Edit_Submit(nId){
	$("#myForm").validate({submitHandler:function(){
		$.post(base_url+"index.php/users/save",
		{
			id:nId, username: $("#username").val(), password: $("#password").val(),
			company:$("#company").val(),
			email:$("#email").val(), phone:$("#phone").val(),
			usergrade:$("#usergrade").is(":checked")?1:0
		}, 
		function (data){
			if (data == true) {
				$.msgBox({
					title:"Alert",
					content:"Successfully saved!"
				});
			}
			else {
				$.msgBox({
					title:"Alert",
					content:"Not saved!"
				});
			}
		});
	},
	invalidHandler: function(){
		$.msgBox({
			title:"Alert",
			content:"All fields are required to be filled out. Please check the form and try  again."
		});
	}});
	return true;
}
function onOrders_Edit_Submit(nId){
	$("#myForm").validate({submitHandler:function(){
		$.post(base_url+"index.php/orders/save",
		{
			id:nId, comment: $("#comment").val()
		}, 
		function (data){
			if (data == true) {
				$.msgBox({
					title:"Alert",
					content:"Successfully saved!"
				});
			}
			else {
				$.msgBox({
					title:"Alert",
					content:"Not saved!"
				});
			}
		});
	},
	invalidHandler: function(){
				$.msgBox({
		 title:"Alert",
		 content:"All fields are required to be filled out. Please check the form and try  again."
		});
	}});
	return true;
}
function onItems_Edit_Submit(nId){
	$("#myForm").validate({submitHandler:function(){
		 $.post(base_url+"index.php/items/save",
		 {
		 id:nId, description: $("#description").val()
	}, 
	 function (data){
			if (data == true) {
				$.msgBox({
		 title:"Alert",
		 content:"Successfully saved!"
		});
			}
			else {
				$.msgBox({
		 title:"Alert",
		 content:"Not saved!"
		});
			}
	});
	},
	invalidHandler: function(){
				$.msgBox({
		 title:"Alert",
		 content:"All fields are required to be filled out. Please check the form and try  again."
		});
	}});
	return true;
}
function onBarcodes_Edit_Submit(nId){
	$("#myForm").validate({submitHandler:function(){
		 $.post(base_url+"index.php/barcodes/save",
		 {
			 id:nId, barcode: $("#barcode").val(), description: $("#description").val()
		}, 
		 function (data){
				if (data == true) {
					$.msgBox({
					 title:"Alert",
					 content:"Successfully saved!"
					});
				}
				else {
					$.msgBox({
					 title:"Alert",
					 content:"Not saved!"
					});
				}
		});
	},
	invalidHandler: function(){
		$.msgBox({
			title:"Alert",
			content:"All fields are required to be filled out. Please check the form and try  again."
		});
	}});
	return true;
}	
function onUsers_Add_Submit(){
   $("#myForm").validate({submitHandler:function(){
		$.post(base_url+"index.php/users/add",
		{
			username: $("#username").val(), password: $("#password").val(),
			firstname:$("#firstname").val(), lastname:$("#lastname").val(), gender:$('input[name=gender]:checked', '#myForm').val(),
			birthday:$("#birthday").val(), country:$("#country").val(), zipcode:$("#zipcode").val(),
			email:$("#email").val(), phonenumber:$("#phonenumber").val(),
			usergrade:$("#usergrade").is(":checked")?1:0
		},
		function (data){
			if (data == true) {
				$.msgBox({
					type:"info",
					title:"Info",
					content:"Successfully saved!"
				});
				$("#username").val("");
				$("#password").val("");
				$("#firstname").val("");
				$("#lastname").val("");
				$("#birthday").val("");
				$("#country").val("");
				$("#zipcode").val("");
				$("#email").val("");
				$("#phonenumber").val("");
				$("#usergrade").prop("checked", false);
				
				$("#username").focus();
			}
			else {
				$.msgBox({
					title:"Alert",
					content:"Not saved!"
				});
			}
		});
	},
	invalidHandler: function(){
		$.msgBox({
			title:"Alert",
			content:"All fields are required to be filled out. Please check the form and try  again."
		});
	}});
	return true;
}
function onBarcodes_Add_Submit(){
   $("#myForm").validate({submitHandler:function(){
		 $.post(base_url+"index.php/barcodes/add",
		 {
		 barcode: $("#barcode").val(), description: $("#description").val()
		}, 
		 function (data){
				if (data == true) {
					$("#barcode").val("");
					$("#description").val("");						
					$("#barcode").focus();
				}
				else {
					$.msgBox({
					 title:"Alert",
					 content:"Not saved!"
					});
				}
		});		
	},
	invalidHandler: function(){
				$.msgBox({
				 title:"Alert",
				 content:"All fields are required to be filled out. Please check the form and try  again."
				});
	}});
	return true;
}	
function onUsersDelete(nId){
	$.msgBox({
		title: "Are You Sure",
		content: "Are you sure you want to delete the user?",
		type: "confirm",
		buttons: [{ value: "Yes" }, { value: "No" }],
		success: function (result) {
			if (result == "Yes") {
				$.post(base_url+"index.php/users/delete", {id:nId}, function(data){console.log(data);
					if (data == true) {
						$.msgBox({
							 title:"Alert",
							 content:"Successfully deleted!"
						});
						document.location.href = base_url+"index.php/users/index";
					}
					else {
						$.msgBox({
							 title:"Alert",
							 content:"Delete failed!"
						});
					}
				});
			}
		}
	});
	return true;
}
function onOrdersDelete(nId){
	$.msgBox({
		title: "Are You Sure",
		content: "Are you sure you want to delete the order?",
		type: "confirm",
		buttons: [{ value: "Yes" }, { value: "No" }],
		success: function (result) {
			if (result == "Yes") {
				$.post(base_url+"index.php/users/deleteCheck", {id:nId}, function(data){
					if (data == true){
						$.post(base_url+"index.php/users/delete", {id:nId}, function(data){
							if (data == true) {
								$.msgBox({
									 title:"Alert",
									 content:"Successfully deleted!"
								});
								document.location.href = base_url+"index.php/users/index";
							}
							else {
								$.msgBox({
									 title:"Alert",
									 content:"Delete failed!"
								});
							}
						});
					} else {
						$.msgBox({
							title:"Alert",
							content:"There are photos using this user!"
						});
					}
				});
			}
		}
	});
	return true;
}
function onBarcodesDelete(nId){
	$.msgBox({
		title: "Are You Sure",
		content: "Are you sure you want to delete the barcode?",
		type: "confirm",
		buttons: [{ value: "Yes" }, { value: "No" }],
		success: function (result) {
			if (result == "Yes") {
					$.post(base_url+"index.php/barcodes/deleteCheck", {id:nId}, function(data){
						if (data == true){
							$.post(base_url+"index.php/barcodes/delete", {id:nId}, function(data){
								if (data == true) {
									$.msgBox({
										 title:"Alert",
										 content:"Successfully deleted!"
									});
									document.location.href = base_url+"index.php/barcodes/index";
								}
								else {
									$.msgBox({
										 title:"Alert",
										 content:"Delete failed!"
									});
								}
							});
						} else {
							$.msgBox({
				 title:"Alert",
				 content:"There are items using this barcode!"
				});
						}
					});
				
			}
		}
	});
	return true;
}
function onAddUser(){
	 document.location.href = base_url+"index.php/users/add_diag";
}
function onAddBarcode(){
	 document.location.href = base_url+"index.php/barcodes/add_diag";
}
function onClick_QueueTr(nId){
   document.location.href = base_url+"index.php/queue/details?id="+nId;
}

function onChangePassword(){
$.msgBox({ type: "prompt",
		title: "Change Password",
		inputs: [
		{ header: "Old Password", type: "password", name: "opassword" },
		{ header: "New Password", type: "password", name: "npassword" },
		{ header: "Confirm Password", type: "password", name: "cpassword" }],
		buttons: [    { value: "OK" }, {value:"Cancel"}],
		success: function (result, values) { 
			if(result == "OK"){
				var passbuf = {opassword:"", npassword:"", cpassword:""};
					$(values).each(function (index, input) {
					passbuf[input.name] = input.value;
				});
				if(passbuf["npassword"] == passbuf["cpassword"]) {
				 $.post(base_url+"index.php/login/changepassword", 
					{oldpw: passbuf["opassword"], newpw: passbuf["npassword"]},
					function (data){
							if (data == true) {
								$.msgBox({
						 title:"Alert",
						 content:"Successfully Changed!"
						});
					}
							else {
								$.msgBox({
						 title:"Alert",
						 content:"Not Changed!"
						});
							}
					}
				);
			}
			else{
				 $.msgBox({
				 title:"Alert",
				 content:"New and Confirm passwords must match!"
			 });
			}
		}
	  }
});
}


function onUserChangePassword(username){
$.msgBox({ type: "prompt",
		title: "Change Password",
		inputs: [
			{ header: "Username", type: "text", name: "username", value: username },
		{ header: "Old Password", type: "password", name: "opassword" },
		{ header: "New Password", type: "password", name: "npassword" },
		{ header: "Confirm Password", type: "password", name: "cpassword" }],
		buttons: [    { value: "OK" }, {value:"Cancel"}],
		success: function (result, values) { 
			if(result == "OK"){
				var passbuf = {"username":"", "opassword":"", "npassword":"", "cpassword":""};
					$(values).each(function (index, input) {
					passbuf[input.name] = input.value;
				});
				if(passbuf["npassword"] == passbuf["cpassword"]) {
				 $.post(base_url+"index.php/login/changeuserpassword", 
					{"username":passbuf["username"], oldpw: passbuf["opassword"], newpw: passbuf["npassword"]},
					function (data){
							if (data == true) {
								$.msgBox({
						 title:"Alert",
						 content:"Successfully Changed!"
						});
					}
							else {
								$.msgBox({
						 title:"Alert",
						 content:"Not Changed!"
						});
							}
					}
				);
			}
			else{
				 $.msgBox({
				 title:"Alert",
				 content:"New and Confirm passwords must match!"
			 });
			}
		}
	  }
});
}
function onUserDelete(nId){
		$.msgBox({
			title: "Are You Sure",
			content: "Are you sure you want to delete the user?",
			type: "confirm",
			buttons: [{ value: "Yes" }, { value: "No" }],
			success: function (result) {
				if (result == "Yes") {
					$.post(base_url+"index.php/login/deleteuser", {id:nId}, function(data){
						if (data == true) {
							$.msgBox({
							 title:"Alert",
							 content:"Successfully deleted!"
							});
							document.location.href = base_url+"index.php/login/manageuser";
						}
						else {
							$.msgBox({
							 title:"Alert",
							 content:"Delete failed!"
							});
						}
					});
				}
			}
		});
		return true;
}
function ConvertToCSV(objArray) {
		var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
		var str = '';

		for (var i = 0; i < array.length; i++) {
			var line = '';
		for (var index in array[i]) {
			if (line != '') line += ','

			line += array[i][index];
		}

		str += line + '\r\n';
	}

	return str;
}
function onExport_Users(){
	$.post(base_url+"index.php/database/export_users",{}, 
	function (data){
		url = base_url + data;
		window.open(url);
	});
	return true;
}
function onExport_Orders(){
	$.post(base_url+"index.php/database/export_orders",{}, 
	function (data){
		url = base_url + data;
		window.open(url);		
	});
	return true;
}
function onImport(){
	type = "user";
	$("#files").trigger("click");
	return true;
}
function onImport_Barcodes(){
	type = "barcode";
	$("#files").trigger("click");
	return true;
}


/*****    Custom Medias	crated by Boris	2015/02/04 06:30 PM   *******/
function onAddMedia(){
	document.location.href = base_url+"index.php/Medias/add_diag";
}
function onMediasEdit(nId){
	document.location.href = base_url+"index.php/Medias/edit?id="+nId;
}
function onMediasDelete(nId){
	$.msgBox({
		title: "Are You Sure",
		content: "Are you sure you want to delete the Media?",
		type: "confirm",
		buttons: [{ value: "Yes" }, { value: "No" }],
		success: function (result) {
			if (result == "Yes") {
				$.post(base_url+"index.php/Medias/delete", {id:nId}, function(data){
					if (data == true) {
						$.msgBox({
							 title:"Alert",
							 content:"Successfully deleted!"
						});
						document.location.href = base_url+"index.php/Medias/index";
					}
					else {
						$.msgBox({
							 title:"Alert",
							 content:"Delete failed!"
						});
					}
				});
			}
		}
	});
	return true;
}


function onEditMedia_Back(){
	document.location.href = base_url+"index.php/Medias/index";
}
function onMedia_Add_Submit(){
   $("#myForm").validate({submitHandler:function(){
		$.post(base_url+"index.php/Medias/add",
		{
			Mediaid: $("#Mediaid").val(), thumbnail: $("#thumbnail").val(),
			url:$("#url").val(), title:$("#title").val(), description:$("#description").val(),
			date:$("#date").val(), ord:$("#ord").val(),
			type:$("#type").is(":checked")?1:0
		},
		function (data){
			if (data == true) {
				$.msgBox({
					type:"info",
					title:"Info",
					content:"Successfully saved!"
				});
				$("#Mediaid").val("");
				$("#thumbnail").val("");
				$("#url").val("");
				$("#title").val("");
				$("#description").val("");
				$("#date").val("");
				$("#ord").val("0");
				$("#type").prop("checked", false);
				
				$("#Mediaid").focus();
			}
			else {
				$.msgBox({
					title:"Alert",
					content:"Not saved!"
				});
			}
		});
	},
	invalidHandler: function(){
		$.msgBox({
			title:"Alert",
			content:"All fields are required to be filled out. Please check the form and try  again."
		});
	}});
	return true;
}
function onMedia_Edit_Submit(nId){
	$("#myForm").validate({submitHandler:function(){
		$.post(base_url+"index.php/Medias/save",
		{
			id:nId, Mediaid: $("#Mediaid").val(), thumbnail: $("#thumbnail").val(),
			url:$("#url").val(), title:$("#title").val(), description:$("#description").val(),
			date:$("#date").val(), ord:$("#ord").val(),
			type:$("#type").is(":checked")?1:0
		}, 
		function (data){
			if (data == true) {
				$.msgBox({
					title:"Alert",
					content:"Successfully saved!"
				});
			}
			else {
				$.msgBox({
					title:"Alert",
					content:"Not saved!"
				});
			}
		});
	},
	invalidHandler: function(){
		$.msgBox({
			title:"Alert",
			content:"All fields are required to be filled out. Please check the form and try  again."
		});
	}});
	return true;
}
