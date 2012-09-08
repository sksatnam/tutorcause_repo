var host = window.location.host;
var proto = window.location.protocol;
var pathArray = window.location.pathname.split('/');
var secondLevelLocation = pathArray[1];
var ajax_url = proto + '//' + host;
ajax_url = ajax_url + '/' + secondLevelLocation; 

$(document).ajaxStart(function() {
  $('#loading').show();
}).ajaxStop(function() {
  $('#loading').hide();
});

$(document).ready(function () {
							
	jQuery.validator.addMethod("dashnumber", function(value, element) {
  return this.optional(element) || /^[0-9-]+$/i.test(value);
}, "Number and dash only");							
	
	jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
}, "Letters only please");							
							
	$.validator.addMethod("letters", function(value, element) {
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Letters only please"); 
    $('#loading').hide();
	
	
	$.validator.addMethod("alpha_num", function(value, element) {
		return this.optional(element) || /^[a-z0-9\s ]+$/i.test(value);
	}, "Alphanumeric values only");
	
	$.validator.addMethod("postalcode", function(postalcode, element) {
		return this.optional(element) || postalcode.match(																					/(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXYabceghjklmnpstvxy]{1}\d{1}[A-Za-z]{1} ?\d{1}[A-Za-z]{1}\d{1})$/);
	}, "Please specify a valid postal/zip code");
	
	
	$.validator.addMethod("postalcodeonly", function(postalcode, element) {
		return this.optional(element) || postalcode.match(																					/(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXYabceghjklmnpstvxy]{1}\d{1}[A-Za-z]{1} ?\d{1}[A-Za-z]{1}\d{1})$/);
	}, "Please specify a valid postal/zip code");
	
	$.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, ""); 
	return this.optional(element) || phone_number.length > 9 &&
		phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please specify a valid phone number");
	
   $.validator.addMethod("NoWhiteSpaceAtBeginn", function(value, element) {
    return this.optional(element) || /^[^\t].*/.test(value);
  }, "Must not begin with a whitespace");

   
   
   //  PHONE FILED VALIDATION FORMAT: ()--
		if ($(".phone").length){
			$("input.phone").mask("(999)999-9999");
		}
		
	
    $("#flashmsg").fadeOut(10000);


    $("#mailAddress").hide();
    $("#paypalLink").slideDown();
    $("#paymentChoose").change(function () {
        if ($(this).val() == 'Mailed Check') {
            $("#paypalLink").hide();
            $("#mailAddress").slideDown();
            $("#mailAdd").addClass("required");
        } else if ($(this).val() == 'Paypal') {
            $("#mailAddress").hide();
            $("#paypalLink").slideDown();
            $("#paypalmail").addClass("required");
        }
    });
	
	
	
	
	 $("#MemberNewPassword").validate({
        rules: {
            "data[Member][cPassword]": {
                required: true,
                equalTo: '#userPassword'
            }


        },
        messages: {
            "data[Member][cPassword]": {
                required: 'This field is required',
                equalTo: 'Password not Match'
            }
        }
    });
	 
	 
	$("#twiddla").validate({
        rules: {
            "data[Api][cPassword]": {
                required: true,
                equalTo: '#Password1'
            }


        },
        messages: {
            "data[Api][cPassword]": {
                required: 'This field is required',
                equalTo: 'Password not Match'
            }
        }
    });


	$("#MemberAddStudent").validate();
	
	$("#MemberAddParent").validate();
	
	$("#minimum_wage").validate();
	
	$("#MemberForgetPassword").validate();

    $("#MemberAddeventForm").validate();
	
	$("#noticeadd").validate();
	
	$("#MemberStudentCourseForm").validate();
	
	$("#TutorRateForm").validate();
	
	$("#MemberChangePassword").validate({
        rules: {
            "data[Member][cPassword]": {
                required: true,
				rangelength: [6, 20],
                equalTo: '#userPassword'
				
            },
			"data[Member][pwd]": {
				required: true,
                rangelength: [6, 20]
            }

        },
        messages: {
            "data[Member][cPassword]": {
                required: 'This field is required',
                equalTo: 'Password not Match',
				rangelength:'Please enter password between {0}-{1} characters.'
            },
			"data[Member][pwd]": {
                required: 'This field is required',             
				rangelength:'Please enter password between {0}-{1} characters.'
            }
        }
    });
	
	
	
	$("#HomeSaveMember").validate({
        rules: {
			"data[userMeta][fname]": {
				rangelength: [3, 20],
            },
			"data[userMeta][lname]": {
             	rangelength: [3, 20],
            },
			"data[Member][pwd]": {
                required: true,
				rangelength: [6, 20],
            },
			"data[Member][cPassword]": {
                required: true,
				rangelength: [6, 20],				
                equalTo: '#MemberPwd',
				
            },
            "data[Member][email]": {
                required: true,
                email: true,
                remote: ajax_url + "/homes/checkMemberEmail"
            },
			"data[userMeta][zip]": {
                remote: function() {
					var p = $('#state').val();
					return ajax_url+"/members/validZipForState?&state=" + p;
				}
            }
        },
        messages: {
			"data[userMeta][fname]": {
				rangelength:'Please enter first name between {0}-{1} characters.',
            },
			"data[userMeta][lname]": {
				rangelength:'Please enter last name between {0}-{1} characters.',
            },
			"data[Member][pwd]": {
				required: 'This field is required',
				rangelength:'Please enter password between {0}-{1} characters.',
			},
			"data[Member][cPassword]": {
                required: 'This field is required',
				rangelength:'Please enter password between {0}-{1} characters.',
                equalTo: 'Password not Match',				
            },
            "data[Member][email]": {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
			"data[userMeta][zip]": {
                remote: "Invalid zip code ,Please select the right state"
            },
        }
   });
	
	
	
	
	
	
	
$("#MemberAddStudent").validate({
				
       		 rules: {
				"data[Member][email]": {
					required: true,
					email: true,
					remote: ajax_url + "/homes/checkMemberEmail"
			   }
        },
			messages: {
				"data[Member][email]": {
					required: "Please enter your email",
					email: "Please enter a valid email address",
					remote: "Email already exist"
				}
			}
  		 });
	
	 var memberid = $('#Memberid').val();
    $("#MemberRegmemberForm").validate({

        rules: {
            "data[Member][group_id]": {
                required: true
               // minlength: 6,				
            },
            "data[userMeta][fname]": {
                required: true,
				//NoWhiteSpaceAtBeginn: true
				letters:true,
				rangelength: [3, 20],
            },
            "data[userMeta][lname]": {
                required: true,
				letters:true,
				rangelength: [3, 20],
            },
            "data[Member][email]": {
                required: true,
                email: true,
                remote: ajax_url + "/members/checkMemberExist?memberid=" + memberid
            },
			"data[userMeta][zip]": {
                remote: function() {
					var p = $('#state').val();
					return ajax_url+"/members/validZipForState?&state=" + p;
				}
            }
        },
        messages: {
            "data[Member][group_id]": {
                required: "Please select userType",
            },
            "data[userMeta][fname]": {
                required: "First Name cannot be blank ",
				rangelength:'Please enter first name between {0}-{1} characters.'
            },
            "data[userMeta][lname]": {
                required: "Last Name cannot be blank",
				rangelength:'Please enter last name between {0}-{1} characters.'
           },
            "data[Member][email]": {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                remote: "Email already exist"
            },
			"data[userMeta][zip]": {
                remote: "Invalid zip code ,Please select the right state"
            },
			"data[userMeta][address]": {
                //required: "Last Name cannot be blank"
				//letters:"Please Alphanumeric values only" 

            }
        }

    });
	
	
	
	
    $("#MemberStep1").validate({
        rules: {
            "data[Member][studentEmail]": {
                required: true,
				email:true
				
            }
        },
		messages: {
            "data[Member][studentEmail]": {
                required: "Please enter Email id",
		email: "Invalid Email ID"
				
            }
        }
    });
    $("#MemberStep2").validate();
    $("#MemberStep3").validate({
        rules: {
            "data[Member][amount]": {
                required: true,
                digits: true
                //minlength: 6				
            }
        }
    });
	
	// validation for add_fund2
	
	 $("#stripepayment").validate({
								  rules: {
									  "parentname": {
										  rangelength: [3, 20],
										  }
									  }
								  
								  });
	


    $('#tutorPaypal').validate({

        rules: {
            "data[Member][payment]": {
                required: true
            },
            "data[Member][paymentFrequency]": {
                required: true
            },
		"data[Member][paypalEmail]":
					{
						required:true,
						email:true
					}
					/*
					"data[Member][mailedCheck]":
					{
						required:true
					}*/

        },
        messages: {
            "data[Member][payment]": {
                required: "Please select payment option"
            },
            "data[Member][paymentFrequency]": {
                required: "Please select payment frequency"
            },
		   "data[Member][paypalEmail]":
					{
						required:"Please enter paypal email",
						email: "Please enter a valid email address"
					}
					/*
					"data[Member][mailedCheck]":
					{
						required:"Please enter mail address"
					}*/


        }



    });




   

//login admin panel ajax addition 
    $("form#MemberLogin").submit(function () {

        if ($('#MemberLogin').validate().form()) {

            var uname = $('#frontendUser').attr('value');
            var upass = $('#frontPass').attr('value');
            var thisHref = ajax_url + "/homes/checkfrontendlogin/";
            var attributes = uname + '/' + upass;
            //alert($("form#AdminLogin").serialize());
            //alert();
            $.post(
            thisHref, $("form#MemberLogin").serialize(), function (data) {
              /*  alert(data);
				return false;*/
				
                if (jQuery.trim(data) == "authorized") {
                    //	 $('#adminuser').val('');
                    //	 $('#pass').val('');
                    // alert('jazz');
                    window.location.reload();
                    // window.location.href = ajax_url;
                } else {
                    //alert("hello");
                    $('div#frontendloginAlert').html(data);

                    $('div#frontendloginAlert').show(500);
                    return false;
                }
            });

        }




        return false;

    });

    if ($("input#frontendUser").length) {
        $("input#frontendUser").focus(function () {
            $('div#frontendloginAlert').hide(300);

        });
    }

    if ($("input#frontPass").length) {
        $("input#frontPass").focus(function () {
            $('div#frontendloginAlert').hide(300);

        });
    }
	



    //login admin panel ajax addition 
    $("form#AdminLogin").submit(function () {

        if ($('#AdminLogin').validate().form()) {

            var uname = $('#adminuser').attr('value');
            var upass = $('#pass').attr('value');
            var thisHref = ajax_url + "/members/checkadminlogin/";
            var attributes = uname + '/' + upass;
            //alert($("form#AdminLogin").serialize());
            //alert();
            $.post(
            thisHref, $("form#AdminLogin").serialize(), function (data) {
                //alert(data);
                if (jQuery.trim(data) == "authorized") {
                    //	 $('#adminuser').val('');
                    //	 $('#pass').val('');
                    // alert('jazz');
                    window.location.reload();
                    // window.location.href = ajax_url;
                } else {
                    //alert("hello");
                    $('div#loginAlert').html(data);

                    $('div#loginAlert').show(500);
                    return false;
                }
            });

        }




        return false;

    });

    if ($("input#adminuser").length) {
        $("input#adminuser").focus(function () {
            $('div#loginAlert').hide(300);

        });
    }

    if ($("input#pass").length) {
        $("input#pass").focus(function () {
            $('div#loginAlert').hide(300);

        });
    }
	
	
	

    if ($("#MemberGroupId").length) {
        $("#MemberGroupId").focus(function () {
            $('div#loginAlert').hide(300);

        });
    }


    //start admin menu coding satnam
    $("#menu li ul").hide();

    $("#menu li").hover(

    function () {
        $(this).children("ul").show();
    }, function () {
        $(this).children("ul").hide();
    }); //hover end admin menu coding



    $("#MemberEditForm").validate();
	$("#Ca1useschool").validate();
	$("#Ca1useschool").valid
    $("#UserAddForm").validate({
        rules: {
            "data[Member][email]": {
                required: true,
                email: true,
                remote: ajax_url + "/Members/checkemail/"

            },
            "data[Member][cPassword]": {
                required: true,
                equalTo: '#MemberPwd'
            },
          /*  "data[Member][school_id]": {
                required: true,
                remote: ajax_url + "/Members/checkeschool/"
            }*/

        },
        messages: {
            "data[Member][email]": {
                required: 'This field is required',
                email: 'Please enter valid email.',
                remote: 'Email Already Exist'
            },
            "data[Member][cPassword]": {
                required: 'This field is required',
                equalTo: 'Password not Match'
            },
           /* "data[Member][school_id]": {
                required: 'This field is required',
                remote: 'School Already Exist'
            }*/
        }
    });



    $("#ChangePasswordForm").validate({
        rules: {
            "data[Member][cPassword]": {
                required: true,
                equalTo: '#AdminPassword1'
            }


        },
        messages: {
            "data[Member][cPassword]": {
                required: 'This field is required',
                equalTo: 'Password not Match'
            }
        }
    });


    //school add form admin area
    $("#SchoolAddForm").validate({
        rules: {
            "data[School][slug]": {
                required: true,
                remote: ajax_url + "/admin/Schools/checkslug/"

            },

            "data[School][school_name]": {
                required: true,
                remote: ajax_url + "/admin/Schools/checkname/"
            },

            "data[School][file]": {
                accept: "(jpe?g|gif|png)"

            },
            "data[School][file1]": {
                accept: "(jpe?g|gif|png)"

            }
        },
        messages: {

            "data[School][slug]": {
                required: 'This field is required',
                remote: 'slug Already Exist'
            },
            "data[School][school_name]": {
                required: 'This Field is required',
                remote: 'This School already exist'
            },

            "data[School][file]": {
                accept: 'Please Upload Image File ( jpeg,gif,png )'
            },
            "data[School][file1]": {
                accept: 'Please Upload Image File ( jpeg,gif,png )'
            }
        }
    });


    //school edit form admin area
    var schoolId = $('#schoolid').val();
    $("#SchoolEditForm").validate({
        rules: {
            "data[School][slug]": {
                required: true,
                remote: ajax_url + "/admin/Schools/checkeditslug/?schoolId=" + schoolId

            },
            "data[School][school_name]": {
                required: true,
                remote: ajax_url + "/admin/Schools/checkeditname/?schoolId=" + schoolId

            },
            "data[School][file]": {
                accept: "(jpe?g|gif|png)"

            },
            "data[School][file1]": {
                accept: "(jpe?g|gif|png)"

            }
        },
        messages: {

            "data[School][slug]": {
                required: 'This field is required',
                remote: 'slug Already Exist'
            },
            "data[School][school_name]": {
                required: 'This field is required',
                remote: 'school Name Already Exist'
            },
            "data[School][file]": {
                accept: 'Please Upload Image File ( jpeg,gif,png )'
            },
            "data[School][file1]": {
                accept: 'Please Upload Image File ( jpeg,gif,png )'
            }
        }
    });





    //Paginate Users data in Admin
    //controller => questions, action => admin_view
    $("div.paging a").live("click", function () {

        var formId = $(this).parents('form').attr('id');
        var divId = $(this).parents('div').attr('id');

        $("#loading").show();

        if ($(formId).length !== 0) {
            loadPiece({
                href: $(this).attr("href"),
                divName: "#pagingDivParent",
                callback: function () {
                    setCheckBoxes(formId);
                }
            });
        } else {
            loadPiece({
                href: $(this).attr("href"),
                divName: "#pagingDivParent",
                callback: function () {
                    setCheckBoxes(formId);
                }
            });
        }

        return false;
    });


    //jquery paginate
    //param
    // for pagination , inputs[ url(where u click), div id name(where u place the output)]


    function loadPiece(obj) {

        if ($("#pagingStatus").length !== '0') {
			$("#pagingStatus").val(obj.href);
        }
        $(obj.divName).load(unescape(obj.href), {}, function () {
            $("#loading").fadeOut('slow'); //hide loading image action=>admin_add_image,action=>school_image_edit
            if (obj.callback) {
                obj.callback();
            }

            setUserDeleteEvent(); //set delete event		
            //		imagePreview();//set image preview when paginate
            var formId = $(this).parents('form').attr('id');
            var divPaginationLinks = obj.divName + " .paging a";

            //	alert(formId+divPaginationLinks);
            $(divPaginationLinks).click(function () {

                $("#ajax-loading").show(); //show loading image action=>admin_add_image,action=>school_image_edit
                var thisHref = $(this).attr("href");
                loadPiece({
                    href: thisHref,
                    divName: obj.divName,
                    callback: function () {
                        setCheckBoxes(formId);
                        if (obj.callback) {
                            obj.callback();
                        } else {
                            '';
                        }
                    }
                });
                return false;
            });
        });
    }


    setUserDeleteEvent();

    //set checkboxes when paginate
    //admin area
    setCheckBoxes('UserViewForm'); //Checked and uncheck all the checkboxes
    //end set boxes

    //Checked and uncheck all the checkboxes
    //for multiple action controller => Users action -> admin_view

    function setCheckBoxes(form) {

        //Checked and unchecked all the checkbox
        //Helps in performing Bulk action
        $("#" + form + " input[type='checkbox']:first").click(function () {
            if ($(this).is(":checked")) {
                $("#" + form + " input[type='checkbox']").each(function () {
                    $(this).attr("checked", "checked");
                });
            } else {
                $("#" + form + " input[type='checkbox']").each(function () {
                    $(this).attr("checked", "");
                });
            }
        });

        $("#" + form + " input[type='checkbox']").click(function () {
            if (!$(this).is(":checked")) {
                $("#" + form + " input[type='checkbox']:first").attr('checked', '');
            }
        });
    }


    /* start admin toggle filter block on all pages */
    $(".slide_toggle").click(function () {
        if ($(".slide_toggle").text() == 'Filter data (click to show)') {
            $(".slide_toggle").text('Filter data (click to hide)');
        } else {
            $(".slide_toggle").text('Filter data (click to show)');
        }
        $(".slide").slideToggle("slow");
    });
    $(".slide_toggle").mouseover(function () {
        $(".slide_toggle").css({
            "background-color": "#B3BBC2",
            "font-color": "#000000"
        });
    });

    $(".slide_toggle").mouseout(function () {
        $(".slide_toggle").css("background-color", "#e5eecc");
    });
    $(".slide").hide();

    /* end admin toggle filter block */


    $(".expandGrid").click(function () {
        if ($('#mid-col').attr('class') == "addWidth") {
            $(this).text("EXPAND GRID");
            $('#left-col').show(0);

            $('#mid-col').animate({
                width: '737px'
            }, 0, function () {
                // Animation complete.
                $(this).removeClass('addWidth');
            });

        } else {
            $(this).text("SHRINK GRID");
            $('#mid-col').css('width', '');
            $('#left-col').hide();

            $('#mid-col').attr('class', 'addWidth').css('width', '100%').show( //"clip", {
            // direction: "horizontal"
            // }, 0
            );

        }
    }); /*     End   */


    // $("#copyschedule").validate();


    //11 july girish  
    //set click event on admin/users
    //for sending ajax request to delete User


    function setUserDeleteEvent() {

        if ($("#pagingDivParent .delete-single-user").length) {
            $("#pagingDivParent .table-delete-link").click(function () {
                var id = $(this).attr('id');

                if (confirm('Are you sure you want to delete this user')) {
                    deleteSingleRecord(id, "/admin/members/delete/");
                }
            });
        }


        if ($("#pagingDivParent .delete-single-course").length) {
            $("#pagingDivParent .table-delete-link").click(function () {
                var id = $(this).attr('id');

                if (confirm('Are you sure you want to delete this course')) {
                    deleteCourseRecord(id, "/admin/schools/courseDelete/");
                }
            });
        }

        if ($("#pagingDivParent .delete-single-school").length) {
            $("#pagingDivParent .table-delete-link").click(function () {
                var id = $(this).attr('id');

                if (confirm('Are you sure you want to delete this school')) {
                    deleteSchoolRecord(id, "/admin/schools/delete/");
                }
            });
        }
		
		if ($("#pagingDivParent .delete-single-school1").length) {
            $("#pagingDivParent .table-delete-link").click(function () {
                var id = $(this).attr('id');
                if (confirm('Are you sure you want to delete this school')) {
                   deleteSchoolRecord1(id, "/admin/schools/upcoming_delete/");
                }
            });
        }


        if ($("#pagingDivParent .delete-single-faq").length) {
            $("#pagingDivParent .table-delete-link").click(function () {
                var id = $(this).attr('id');

                if (confirm('Are you sure you want to delete this Faq')) {
                    deleteFaqRecord(id, "/admin/faqs/faq_delete/");
                }
            });
        }
		
		   if ($("#pagingDivParent .delete-single-notice").length) {
            $("#pagingDivParent .table-delete-link").click(function () {
                var id = $(this).attr('id');
			
                if (confirm('Are you sure you want to delete this notice')) {
			        deleteNoticeRecord(id, "/admin/notices/notice_delete/");
                }
            });
        }


    }

    //for deleting single record
    //param@ record id and table name


    function deleteSingleRecord(id, url) {
        if ($("#pagingStatus").val() === '') {
            $("#pagingStatus").val(ajax_url + '/admin/members/memberView');
        }

        $("#loading").show(); //show loading image
        var delId = id.replace("del_", "");
        $.ajax({
            type: "GET",
            url: ajax_url + url + delId,
            data: '',
            success: function (html) {
                if (jQuery.trim(html) == "deleted") {
                    $("#loading").fadeOut('slow'); //hide loading image
                    $("#del_" + delId).parents('tr').fadeOut('slow', function () {
                        $("#del_" + id).remove();
                    });
                    loadPiece({
                        href: $("#pagingStatus").val(),
                        divName: "#pagingDivParent",
                        callback: function () {
                            setCheckBoxes('UserViewForm');
                        }
                    });
                }
            }
        });
    }


    function deleteCourseRecord(id, url) {
        if ($("#pagingStatus").val() === '') {
            $("#pagingStatus").val(ajax_url + '/admin/schools/courseView/');
        }

        $("#loading").show(); //show loading image
        var delId = id.replace("del_", "");

        $.ajax({
            type: "GET",
            url: ajax_url + url + delId,
            data: '',
            success: function (html) {
                if (jQuery.trim(html) == "deleted") {
                    $("#loading").fadeOut('slow'); //hide loading image
                    $("#del_" + delId).parents('tr').fadeOut('slow', function () {
                        $("#del_" + id).remove();
                    })
                    loadPiece({
                        href: $("#pagingStatus").val(),
                        divName: "#pagingDivParent",
                        callback: function () {
                            setCheckBoxes('UserViewForm');
                        }
                    });
                }
            }
        });
    }

    function deleteSchoolRecord(id, url) {
        if ($("#pagingStatus").val() === '') {
            $("#pagingStatus").val(ajax_url + '/admin/schools/view/');
        }
        $("#loading").show();

        var delId = id.replace("del_", "");

        $.ajax({
            type: "GET",
            url: ajax_url + url + delId,
            data: '',
            success: function (html) {
                if (jQuery.trim(html) == "deleted") {
                    $("#loading").fadeOut('slow');
                    $("#del_" + delId).parents('tr').fadeOut('slow', function () {
                        $("#del_" + id).remove();
                    })
                    loadPiece({
                        href: $("#pagingStatus").val(),
                        divName: "#pagingDivParent",
                        callback: function () {}
                    });
                }
            }
        });
    }
	
	 function deleteNoticeRecord(id, url) {
     /*   if ($("#pagingStatus").val() === '') {
            $("#pagingStatus").val(ajax_url + '/admin/notices/notice_view/');
        }
		
        $("#loading").show();  */

        var delId = id.replace("del_", "");

        $.ajax({
            type: "GET",
            url: ajax_url + url + delId,
            data: '',
            success: function (html) {
				
                if (jQuery.trim(html) == "deleted") {
                 /*   $("#loading").fadeOut('slow');
                   $("#del_" + delId).parents('tr').fadeOut('slow', function () {
                        $("#del_" + id).remove();
                    })*/
                    loadPiece({
                        href: $("#pagingStatus").val(),
                        divName: "#pagingDivParent",
                        callback: function () {}
                    });
                }
            }
        });
    }

	
	


	function deleteSchoolRecord1(id, url) {
        if ($("#pagingStatus").val() === '') {
            $("#pagingStatus").val(ajax_url + '/admin/schools/upcoming_view/');
        }
        $("#loading").show();

        var delId = id.replace("del_", "");

        $.ajax({
            type: "GET",
            url: ajax_url + url + delId,
            data: '',
            success: function (html) {
                if (jQuery.trim(html) == "deleted") {
                    $("#loading").fadeOut('slow');
                    $("#del_" + delId).parents('tr').fadeOut('slow', function () {
                        $("#del_" + id).remove();
                    })
                    loadPiece({
                        href: $("#pagingStatus").val(),
                        divName: "#pagingDivParent",
                        callback: function () {}
                    });
                }
            }
        });
    }

    function deleteFaqRecord(id, url) {
      /*  if ($("#pagingStatus").val() === '') {
            $("#pagingStatus").val(ajax_url + '/admin/faqs/faqView/');
        }
		
        $("#loading").show(); */

        var delId = id.replace("del_", "");

        $.ajax({
            type: "GET",
            url: ajax_url + url + delId,
            data: '',
            success: function (html) {
                if (jQuery.trim(html) == "deleted") {
                  /*   $("#loading").fadeOut('slow');
                   $("#del_" + delId).parents('tr').fadeOut('slow', function () {
                        $("#del_" + id).remove();
                    })*/
                    loadPiece({
                        href: $("#pagingStatus").val(),
                        divName: "#pagingDivParent",
                        callback: function () {}
                    });
                }
            }
        });
    }
    // end 11 july girish		

    var schoolId = $('#schoolid').val();

    $("#SchoolCourseEditForm").validate({
        rules: {
            "data[Course][course_id]": {
                required: true,
                remote: ajax_url + "/Schools/checkeditcourseid/?schoolId=" + schoolId

            },
            "data[Course][course_title]": {
                required: true,
                remote: ajax_url + "/Schools/checkeditcoursename/?schoolId=" + schoolId

            }

        },
        messages: {

            "data[Course][course_id]": {
                required: 'This field is required',
                remote: 'CourseId Already Exist'
            },
            "data[Course][course_title]": {
                required: 'This field is required',
                remote: 'Course Name Already Exist'
            }
        }
    });
    var schoolId = $('#schoolid').val();

    $('#formsubmitbutton').click(function () {
        checkCourseId(function (response) {
            if (response) {
                $('#SchoolCourseAddForm').submit();
            }
        });
    });

    function checkCourseId(callback) {
        var dataurl = ajax_url + "/Schools/checkcourseid/";
        var schoolId = $('#courseaddschoolId').val();
        var courseCode = $('#courseCode').val();
        $('#schoolMsg').text('');
        $('#courseCodeMsg').text('');
        $('#courseTitleMsg').text('');
        if (schoolId === "") {
            $('#schoolMsg').text("Please select school");
        } else if (courseCode === "") {
            $('#courseCodeMsg').text("Please enter course code");
        } else {
            $.ajax({
                type: "POST",
                url: dataurl,
                async: true,
                data: "&schoolId=" + schoolId + "&courseCode=" + courseCode,
                success: function (response) {
                    if (parseInt(response,10) > 0) {
                        $('#courseCodeMsg').text("Course code already exist");
                        return false;
                    } else {
                        checkCourseName(function (get) {
                            callback(true);
                        })
                    }
                }
            });
        }
    }

    function checkCourseName(callback) {
        var dataurl = ajax_url + "/Schools/checkcoursename/";
        var schoolId = $('#courseaddschoolId').val();
        var courseName = $('#course_title').val();
        if (courseName === "") {
            $('#courseTitleMsg').text("Please enter course name");
        } else {
            $.ajax({
                type: "POST",
                url: dataurl,
                data: "&schoolId=" + schoolId + "&courseCode=" + courseName,
                success: function (response) {
                    if (parseInt(response,10) > 0) {
                        $('#courseTitleMsg').text("Course name already exist");
                        return false;
                    } else {
                        callback(response)
                    }
                }
            });
        }
    }

    $("#SchoolAddAssignCourseForm").validate();

    $("#uploads").validate({
        rules: {
            "data[Course][school_id]": {
                required: true


            },
            "action_file": {
                accept: "(xls)"

            }
        },
        messages: {

            "data[Course][school_id]": {
                required: 'This field is required'
            },
            "action_file": {
                accept: 'Please Upload Excel File'
            }
        }


    });



    $("#Causeschool").validate();

    $("#Studentschool").validate();

    $("#MemberTestingForm").validate();

    $("#MemberBookTutorCourseForm").validate();

    $("#TutCourseEditschoolinfoForm").validate({
        rules: {
            "data[TutCourse][course_id]": {
                required: true
                //minlength: 6				
            },

            "data[TutCourse][rate]": {
                required: true
                //minlength: 6				
            }
        },



        messages: {
            "data[TutCourse][course_id]": {
                required: "Please Enter the Course"
            },

            "data[TutCourse][rate]": {
                required: "Please Enter the rate"
            }
        }
    });



    if ($(".datepicker").length) {
/* $(".datepicker").click(function()
		{
			
			$(this).datepicker();
		}); */
        var dates = $('#DateFrom, #DateTo').datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            numberOfMonths: 1,
            onSelect: function (selectedDate) {
                var option = this.id == "DateFrom" ? "minDate" : "maxDate";
                var instance = $(this).data("datepicker");
                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
            }
        });
    }
//	$("#ur").clock({"format":"12","calendar":"false"});
});
$.fn.stripTags = function() {
	var afterReplace = this.val().replace(/<\/?[^>]+>/gi, '');
	var replacesText = this.val(afterReplace);
	return replacesText;
}


function sendMessage(){
	
	var subject = $('#subject').val().length;
	
	if(subject > 0)
	{
		if(subject >= 3 && subject <= 20){
		
		}
		else
		{
			alert("Please enter a value between 3 and 20 characters long.")
			return false;
		
		}
	}
	else
	{
		alert("Please enter subject");
		return false;
	}
	
	
	
	var originalContent = $('#message').val().length;
	var afterStrip = $('#message').stripTags().val().length;
	var orginalSubject = $('#subject').val().length;
	var afterStripSubject = $('#subject').stripTags().val().length;
	if(parseInt(afterStrip)!= parseInt(originalContent)){
		alert("HTML content not allowed!");
	} else if(parseInt(afterStripSubject)!= parseInt(orginalSubject)){
		alert("HTML content not allowed!");
	}else if($.trim($('#message').val())===""){
		alert("Please enter message");
	}
	else if($('#message').val().length <= 15){
		alert("Please enter a message that contains at least 15 characters.");
	}else {
		var queryString = "&tutorId="+ $('#toTutId').val()+"&subject="+$('#subject').val()+"&message="+$('#message').val();
		$.ajax({
			type: "POST",
			url: ajax_url+"/members/send_msg_to_tutor",
			data: queryString,
			success: function(response){
				$("#dialog-form1").dialog("close");
				$('.modal_msg').html(response);
				$(".modal_msg").dialog({
					autoOpen: false,width: 400,modal: true,buttons:{
						"Ok": function(){
							$( this ).dialog("close");
						}
					}
				});
				$(".modal_msg").dialog("open");
			}
		});
	}
}

