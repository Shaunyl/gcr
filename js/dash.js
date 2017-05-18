$(document).ready(function(){    
    $('.utils2 span').css({'right': fix.utils2span_right});    
});

var oldusername;
var oldwebsite;
var oldlocation;
var oldbirth;
var oldrealname;
var oldaboutme;
var genderChecked = null;
var genderChanged = false;

$(document).on("click", "span.editusername,span.editprofile,span.editaboutme", function () {
	if ($(this).hasClass('editusername')){
	    var txt = $(".username").text().trim();
	    oldusername = txt;
	    toTextArea('username', txt, '');

	    $(this).text(lang.save);
	    $(this).toggleClass('editusername saveusername');
	    
	    $(".username").focusToEnd();
	} else if ($(this).hasClass('editprofile')){
	    var website = $(".website").text().trim();
	    var location = $(".location").text().trim();
	  	var realname = $(".realname").text().trim();
	 	
	 	var birth = function () {
	 		var tmp = null;
			$.ajax({
				'async': false,
			    url: "/gcr/bridge.php",
			    type: "POST",
			    data: { func: 'getBirth' },
			    cache: false,
			    success: function (response) {
					tmp = response.replace(/-/g , "/").trim();
			    }
			});
			return tmp;
		}();

	    oldwebsite = website;
	    oldlocation = location;
	    oldbirth = birth;
	    oldrealname = realname;
		$('.agebirth').text(lang.birth);
	    
	    toTextArea('website', website, 'link to your website (omit the prefix)');
	    $('.website').css('text-decoration', 'none');
		$('.website').css('cursor', 'text');
	    toTextArea('location', location, '');    
	    toTextArea('age', birth, 'YYYY/MM/DD is the pattern accepted..');
	    toTextArea('realname', realname, '');
	 
	    $(this).html($(this).html().replace(lang.edit, lang.save));
	    $(this).toggleClass('editprofile saveprofile');
	    
	    $(".website").focusToEnd();
	    $(".chpic").removeClass('chpic').addClass('chpicoff');
	    
	    // Gender
	    
	    $('fieldset.genderchoose').css("display", "inline");
	    $('img.genderimage').css("display", "none");
	    
	} else if ($(this).hasClass('editaboutme')){
	    var txt = $(".aboutme").text().trim();
	    oldaboutme = txt;

		$(".aboutme").attr("readonly", false);
		$(".aboutme").attr("onfocus", "");
	    $(this).html($(this).html().replace(lang.edit, lang.save));
	    $(this).toggleClass('editaboutme saveaboutme');
	    
	    $(".aboutme").focusToEnd();
	}
});

$(document).on("click", "span.saveaboutme", function () {
	var aboutme = $('.aboutme').val();
	
	if (aboutme.length > 400) {
		$('.aboutmewarn').hide();
		$('.aboutmesaved').hide();
		$('.aboutmenotsaved').text(lang.error_aboutme);
		$('.aboutmenotsaved').show().delay(100).delay(12000).fadeOut(3000);
		return;
	}
	
	if (aboutme == oldaboutme) {
		$('.aboutmesaved').hide();
		$('.aboutmenotsaved').hide();
		$('.aboutmewarn').text(lang.warn_aboutme);
		$('.aboutmewarn').show().delay(100).delay(12000).fadeOut(3000);
	} else {
	    $.ajax({
	        url: "/gcr/bridge.php",
	        type: "POST",
	        data: { func: 'updateAboutMe', aboutme: aboutme },
	        cache: false,
	        success: function (response) {
				if (response == true) {
					$(".aboutme").text(aboutme);
					$('.aboutmewarn').hide();
					$('.aboutmenotsaved').hide();
					$('.aboutmesaved').show().delay(100).delay(12000).fadeOut(3000);	
				} else {
					$(".website").text(oldaboutme);
				}
	        },
			error: function() {
				// connection or call get errors
				$(".website").text(oldaboutme);
			}
	    });
    }
    
	$(this).html($(this).html().replace(lang.save, lang.edit));
	$(this).toggleClass('saveaboutme editaboutme');
	$(".aboutme").attr("readonly", true);
	$(".aboutme").attr("onfocus", "this.blur()");
});


$(document).on("click", "span.saveusername", function () {
	var txt = $('.username').val();
	
	if (txt.length < 5 || txt.length > 25) {
		$('.usernamenotsaved').text(lang.error_username_length);
		$('.usernamewarn').hide();
		$('.usernamesaved').hide();
		$('.usernamenotsaved').show();	
		$(".username").text(oldusername);
		return;
	}
	
	toLabel('username');
    $.ajax({
        url: "/gcr/bridge.php",
        type: "POST",
        data: { func: 'updateUsername', username: txt },
        cache: false,
        success: function (response) {
			if (response == true) {
				$(".username").text(txt);
				$('.usernamenotsaved').hide();
				$('.usernamewarn').hide();
				$('.usernamesaved').show().delay(100).delay(12000).fadeOut(3000);
			} else {
				// If the user already exists..
				if (txt == oldusername) {
					$('.usernamewarn').text(lang.warn_username);
					$('.usernamenotsaved').hide();
					$('.usernamesaved').hide();
					$('.usernamewarn').show().delay(100).delay(12000).fadeOut(3000);
				} else {
					$('.usernamenotsaved').text(lang.error_username_exists1 + txt + lang.error_username_exists2);
					$('.usernamewarn').hide();
					$('.usernamesaved').hide();
					$('.usernamenotsaved').show();	
				}
				$(".username").text(oldusername);
			}
        },
		error: function() {
			// connection or call get errors
		  	$(".username").text(oldusername);
		}
    });
        
    $(this).text(lang.edit);
    $(this).toggleClass('saveusername editusername');
});

$(document).on("click", "span.saveprofile", function () {
	
	var website = $('.website').val();
	var location = $('.location').val();
	var age = $('.age').val().trim();
	var realname = $('.realname').val();
	
	var isValid = isValidDate(age);
	if (!isValid && age != '') {
		$('.profilenotsaved').text(lang.error_profile_date);
		$('.profilewarn').hide();
		$('.profilesaved').hide();	
		$('.profilenotsaved').show();
		return;
	}
	
	$('.agebirth').text(lang.age);
	toLabel('website', website);
	$('.website').css('text-decoration', 'underline');
	$('.website').css('cursor', 'pointer');
	
    toLabel('location', location);
    toLabel('age', age);
    toLabel('realname', realname);
    
    if (oldwebsite == website && oldlocation == location && oldbirth == age && oldrealname == realname && !genderChanged) {
		$('.profilewarn').text(lang.warn_profile);
		$('.profilenotsaved').hide();
		$('.profilesaved').hide();
		$('.profilewarn').show().delay(100).delay(12000).fadeOut(3000);
		$(".age").text(oldbirth ? getAge(oldbirth) : '');
		$(this).html($(this).html().replace(lang.save, lang.edit)); //redundant
		$(this).toggleClass('saveprofile editprofile');
		$(".chpicoff").removeClass('chpicoff').addClass('chpic');
		$('fieldset.genderchoose').css("display", "none");
		$('img.genderimage').css("display", "inline");
		// toggleGender(); // temp.. i can only change gender, obviously..
    	return;
    }
    toggleGender();
	
    $.ajax({
        url: "/gcr/bridge.php",
        type: "POST",
        data: { func: 'updateProfile', website: website, location: location, age: age, realname: realname, gender: genderChecked },
        cache: false,
        success: function (response) {
			if (response == true) {
				$(".website").text(website);
				$(".location").text(location);
				$(".age").text(age ? getAge(age) : '');
				$(".realname").text(realname);
				$('.profilenotsaved').hide();
				$('.profilewarn').hide();
				$('.profilesaved').show().delay(100).delay(12000).fadeOut(3000);
			} else {
				$(".website").text(oldwebsite);
				$(".location").text(oldlocation);
				$(".age").text(getAge(oldbirth ? getAge(oldbirth) : ''));
				$(".realname").text(oldrealname);
			}
        },
		error: function() {
			// connection or call get errors
			$(".website").text(oldwebsite);
			$(".location").text(oldlocation);
			$(".age").text(getAge(oldbirth ? getAge(oldbirth) : ''));
			$(".realname").text(oldrealname);
		}
    });
    
	$(this).html($(this).html().replace(lang.save, lang.edit)); //redundant
	$(this).toggleClass('saveprofile editprofile');
	$(".chpicoff").removeClass('chpicoff').addClass('chpic');
	$('fieldset.genderchoose').css("display", "none");
	$('img.genderimage').css("display", "inline");
});

function toTextArea(clazz, txt, placeholder) {
	$('.' + clazz).replaceWith("<input placeholder=\"" + placeholder  + "\" class='" + clazz + "' style=\"border: 1px solid rgb(231, 231, 231); padding: 3px 5px; color: rgb(81, 81, 81); width: 250px;\"/>");
	$('.' + clazz).val(txt);
}

function toLabel(clazz, txt) {
	var websitefix = '';
	if (clazz == 'website') {
		websitefix = "onclick=\"location.href='http://" + txt + "'\";";
	}
	$('.' + clazz).replaceWith("<label class='" + clazz + "' " + websitefix + "></label>");
	$('.' + clazz).text(txt);
}

; (function($) {
    $.fn.focusToEnd = function() {
        return this.each(function() {
            var v = $(this).val();
            $(this).focus().val("").val(v);
        });
    };
})(jQuery);

$.fn.extend({
    hasClasses: function (classArray) {
        var $this = $(this);
        var classList = '.' + classArray.join('.');
        console.log(classList);
        //Use .is() to check if the classes are present in the selector
        if ($this.is(classList)) {
            return true;
        }
        return false;
    }
});

// Validates that the input string is a valid date formatted as "yyyy/mm/dd"
function isValidDate(dateString)
{
    // First check for the pattern
    if(!/^\d{4}\/\d{1,2}\/\d{1,2}$/.test(dateString))
        return false;

    // Parse the date parts to integers
    var parts = dateString.split("/");
    
    var year = parseInt(parts[0], 10);
    var day = parseInt(parts[2], 10);
    var month = parseInt(parts[1], 10);

    // Check the ranges of month and year
    if(year < 1890 || year > 2014 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
};

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

$(function() {
  $(".genderzone")
    .mouseover(function() { 
        $('.chpic').css('display', 'inline');
    })
    .mouseout(function() {
        $('.chpic').css('display', 'none');
    });
 });

$(function() {
  $(".lblchpic")
    .mouseover(function() { 
        $(this).css('text-decoration', 'underline');
    })
    .mouseout(function() {
        $(this).css('text-decoration', 'none');
    });
});

$(document).on("click", ".lblchpic", function () {
	  $("#dialog").dialog({
			  width: 650
	  });
});

/*
 * During the rename of the username, i need to check two things:
 * 	the former is related to the length of the string: it has to be at least six characters
 *  the latter is related to the availability of the new name in the database [OK]
 */

$("input:checkbox").click(function() {
	genderChanged = true;
    if ($(this).is(":checked")) {
        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
        $(group).prop("checked", false);
        $(this).prop("checked", true);
    } else {
        $(this).prop("checked", false);
    }
});

function toggleGender () { // path problems? (directory...)
   if ($('input.male').is(":checked")) {
   		genderChecked = 'M';
   		$(".genderimage").attr("src", "/gcr/images/dash/M.svg");
   } else if ($('input.female').is(":checked")) {
   		genderChecked = 'F';
        $('.genderimage').attr("src", "/gcr/images/dash/F.svg");
   } else {
   		$('.genderimage').attr("src", "/gcr/images/dash/nogender.svg");
   }
}

// $(document).on("click", "span.showhide-chart-total-distance,span.showhide-chart-average-speed", function () {
	// if ($(this).hasClass('showhide-chart-total-distance')) {
		// $('#chart-total-distance').toggle();
	// } else if ($(this).hasClass('showhide-chart-average-speed')) {
		// $('#chart-average-speed').toggle();
	// }
// });








