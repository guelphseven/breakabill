var remain = 0.0;
var last = new Array();
var max_sizes = new Array();
var hasAmount = false;
var lockScroll = false;
var lockText = false;
$('body').ready(function()
{
	checkSize();
	$('#person-slider-0').slider({		
		change: function(event, ui){if (!lockScroll){checkSlide(event, ui, 0);}},
		range: "min",
		min: 0,
		max: 1,
		step: 0.01,
		disabled: true
	});
	//
	$('#person-amount-0').change(function(e)
	{
		if (!lockText)
		{
			personAmountChange(e, 0);
		}
	});
	last[0] = 0;
	$('#person-slider-0').css('width', '90%');
	$('#person-slider-0').css('margin', 'auto');
	$(window).resize(function(e)
	{
		checkSize();
	});
	$('#send').click(function(e)
	{
		sendMail(e);
	});
	$('#billAmount').change(function(e)
	{
		updateAmount();
	});
	if ($('#billAmount').val() != 0)
	{
		updateAmount();
	}
	$('#ballance').click(function (e) {
		setEqual();
	});
	$('#save').click(function(e)
	{
	var json = {
		billName : $('#billName').val(),
		billMaker : $('#billMaker').val(),
		billAmount : $('#billAmount').val(),
		makerEmail : $('#makerEmail').val(),
		duedate : $('#datepicker').val(),
		total : ($('#person-amount-0').val()),
		people : []
		};
		
	if (isNaN(json.total)) json.total = 0;
	var total = parseInt($('#total-people').val());

	for (i=1; i<=total; i++)
	{
		if (parseInt($('#person-deleted-'+i).val()) == 0)
		{
			//json.people[i].push();
			var the_name = $('#person-name-'+i).val();
			var the_email = $('#person-email-'+i).val();
			var the_total = $('#person-amount-'+i).val();
			
			json.people.push( {
				name : the_name,
				email : the_email,
				total : the_total
			});
		}
	}

		var test = JSON.stringify(json);
		$.ajax({
			url: "../../db/saveBill.php",
			type: "POST",
			data: "data="+test,
			success: function(response)
			{
				//alert(response);
				window.location = "home.php";
			},
			error: function ()
			{
			}
		});
	});
});
function sendMail(e)
{
	var json = {
		billName : $('#billName').val(),
		billMaker : $('#billMaker').val(),
		billAmount : $('#billAmount').val(),
		makerEmail : $('#makerEmail').val(),
		duedate : $('#datepicker').val(),
		total : ($('#person-amount-0').val()),
		people : []
		};
		
	if (isNaN(json.total)) json.total = 0;
	var total = parseInt($('#total-people').val());

	for (i=1; i<=total; i++)
	{
		if (parseInt($('#person-deleted-'+i).val()) == 0)
		{
			//json.people[i].push();
			var the_name = $('#person-name-'+i).val();
			var the_email = $('#person-email-'+i).val();
			var the_total = $('#person-amount-'+i).val();
			
			json.people.push( {
				name : the_name,
				email : the_email,
				total : the_total
			});
		}
	}

	var test = JSON.stringify(json);
	$.ajax({
		url: "../../phpMailer/phpMail.php",
		type: "POST",
		data: "data="+test,
		success: function(response)
		{
			alert("Messages sent.");
			window.location = "home.php";
		},
		error: function ()
		{
		}
	});
}
function addPerson()
{
	var total = parseInt($("#total-people").val());
	var current = total + 1;
	$('#people').append(" \
	<div class='personcontainer' id='person-container-"+current+"'>\
		<div class='fieldrow'>\
			<div class='leftfield'>Name: </div>\
			<div class='rightfield'><input type='text' class='personinput' id='person-name-"+current+"'/></div>\
		</div>		\
		<div class='fieldrow'>\
			<div class='leftfield'>Email: </div>\
			<div class='rightfield'><input type='text' class='personinput' id='person-email-"+current+"'/></div>\
		</div>\
		<div class='fieldrow'>\
			<div class='leftfield slice'>Amount: $<input type='text' id='person-amount-"+current+"' class='moneyslice' value='0.00'/></div>\
			<div class='rightfield slice'><div id='person-slider-"+current+"'></div></div>\
		</div>\
		<div class='fieldrow buttonrow'>\
			<button onclick='deletePerson("+current+")'>Delete</button>\
		</div>\
		<input type='hidden' id='person-deleted-"+current+"' value='0'/>\
	</div>\
	");
	$('#people').find("button").button();
	if (hasAmount == true)
	{
		$('#person-slider-'+current).slider({
			change: function(event, ui){if (!lockScroll){checkSlide(event, ui, current);}},
			range: "min",
			min: 0,
			max: $('#billAmount').val(),
			step: 0.01
		});
	}
	else
	{
		$('#person-slider-'+current).slider({
			change: function(event, ui){if (!lockScroll) {checkSlide(event, ui, current);}},
			range: "min",
			min: 0,
			max: 1,
			step: 0.01,
			disabled: true
		});
	}
	$('#person-amount-'+current).change(function(e)
	{
		if (!lockText) {personAmountChange(e, current);}
	});
	//$('#person-slider-'+current).bind("slidechange", function(event, ui){checkSlide(event, ui, current);});
	$('#person-slider-'+current).css('width', "90%");
	$('#person-slider-'+current).css('margin', "auto");
	$('#person-slider-'+current).css('margin-top', "3px");
	//$('#person-slider-'+current).slider("value", 57);
	total++;
	$("#total-people").val(total);
	last[current] = 0;
	setMax();
}
function deletePerson(num)
{
	$('#person-deleted-'+num).val(1);
	$('#person-container-'+num).hide();
	remain += $('#person-amount-'+num).val();
	setMax();
}
function checkSize()
{
	if ($(window).width() < 750)
	{
		$('#left').addClass("mobile");
		$('.right').addClass("mobile");
		$('.peoplecontainer').addClass("mobile");
		$('.addcontainer').addClass("mobile");
		$('.footer').addClass("mobile");
		$('#maincontainer').addClass("mobile");
	}
	else
	{
		$('#left').removeClass("mobile");
		$('.right').removeClass("mobile");
		$('.peoplecontainer').removeClass("mobile");
		$('.addcontainer').removeClass("mobile");
		$('.footer').removeClass("mobile");
		$('#maincontainer').removeClass("mobile");
	}
}
function updateAmount()
{
	if (parseFloat($('#billAmount').val()) > 10000)
	{
		alert ("Sorry, to split bills of this size you must register an enterprise account.");
		$('#billAmount').val(0);
		return;
	}
	remain = $('#billAmount').val();
	var slider = "#person-slider-";
	var deleted = "#person-deleted-";
	var numsliders = $('#total-people').val();
	var total = remain;
	var percents = new Array();
	lockText = true;
	if (hasAmount == false)
	{
		hasAmount = true;
		for (i=0; i<=numsliders; i++)
		{
			$('#person-slider-'+i).slider("option", "disabled", false);
		}
	}
	for (i=0; i<=numsliders; i++)
	{
		if ($('body').find(deleted+i).val()==0)
		{
			value = "#person-amount-"+i;
			//slidervalue = $('body').find(slider+i).slider("value");
			percents[i] = $(slider+i).slider("value") / $(slider+i).slider("option", "max");
			//alert(percents[i]*total);
			//$(slider+i).val(total * percent);
			howmuch = total * percents[i];
			remain -= howmuch;
			max_sizes[i] = Infinity;
			//$('body').find(value).val(howmuch);
		}
		
	}
	//alert(remain);
	
	for (i=0; i<=numsliders; i++)
	{
		if ($('body').find(deleted+i).val()==0)
		{
			$(slider+i).slider("option", "max", total);
			//alert(percents[i]*total);
			$(slider+i).slider("value", percents[i]*total);
			max_sizes[i] = 0;
		}
	}
	lockText = false;
	setMax();
}
function setMax()
{
	var slider = "#person-slider-";
	var deleted = "#person-deleted-";
	var numsliders = $('#total-people').val();
	var total = $('#billAmount').val();
	//alert(percent_remain);
	for (i=0; i<=numsliders; i++)
	{
		if ($('body').find(deleted+i).val()==0)
		{
			if (max_sizes[i] == Infinity) return;
			//$('body').find(slider+i).slider("max", $('body').find(slider+i).slider("value") + percent_remain);
			//$('body').find("person-email-"+i).val($('body').find(slider+i).slider("value") + percent_remain*1000000);
			max_sizes[i] = Math.round(($('body').find(slider+i).slider("value") + remain)*100)/100;
		}
	}
}
function personAmountChange(event, number)
{
	var slider = "#person-slider-"+number;
	var value = "#person-amount-"+number;
	var total = $('#billAmount').val();
	var amount = Math.round(parseInt($(value).val())*100)/100;
	//var last_amount = total * (last[number]/1000000);
	if (isNaN($(value).val()) || $(value).val() < 0)
	{
		return;
	}
	
	//lockText = true;
	max_amount = last[number] + remain;
	if (amount > last[number])
	{
		if (amount > max_amount)
		{
			amount = max_amount;
			remain = 0;
			
			$(value).val(amount);
		}
		else
		{
			//var percent = (amount / total) *1000000;
			remain -= (amount - last[number]);
			last[number] = amount;
			$(slider).slider("value", amount);
			setMax();
		}
	}
	else if (amount < last[number])
	{
		var delta = last[number] - amount;
		$(slider).slider("value", amount);
		last[number] = amount;
		setMax();
	}
	//lockText = false;
}
function checkSlide(event, ui, number)
{
	var slider = "#person-slider-"+number;
	var value = "#person-amount-"+number;
	var total = $('#billAmount').val();
	var slidervalue = $('body').find(slider).slider("value");
	if (max_sizes[number] == null) max_sizes[number] = Math.round(remain*100)/100;
	lockText = true;
	if (slidervalue > last[number])
	{
		if (slidervalue > max_sizes[number])
		{
			$('body').find(slider).slider("value", Math.round(max_sizes[number]*100)/100);
		}
		else
		{
			var howmuch = slidervalue;
			var previous_amount = last[number];
			
			remain -= (howmuch - previous_amount);
			if (remain < 0) remain = 0;
			$('body').find(value).val(howmuch);
			last[number] = slidervalue;
			setMax();
		}
	}
	else if (slidervalue < last[number])
	{
		var howmuch = slidervalue;
		var previous_amount = last[number];
		
		remain += (previous_amount - howmuch);
		$('body').find(value).val(howmuch);
		last[number] = slidervalue;
		setMax();
	}
	lockText = false;
}
function findTotalPeople()
{
	var max = $('#total-people').val();
	var count = 1;
	var dis = "#person-deleted-";
	for (i=1; i<=max; i++)
	{
		if ($(dis+i).val() == 0)
		{
			count++;
		}
	}
	return count;
}
function setEqual()
{
	var total = findTotalPeople();
	var amount = parseFloat($('#billAmount').val());
	var equalsplit = amount / total;
	lockText = true;
	var person_amount = "#person-slider-";
	var del = "#person-deleted-";
	lockScroll = true;
	remain = amount;
	for (var i=0; i<=total; i++)
	{
		if (parseInt($(del+i).val()) != 0) continue;
		$(person_amount+i).slider("value", 0);
		last[i] = 0;
	}
	lockScroll = false;
	setMax();
	lockText = true;
	for (var i=0; i<=total; i++)
	{
		if (parseInt($(del+i).val()) != 0) continue;
		$(person_amount+i).slider("value", equalsplit);
	}
	lockText = false;
}
