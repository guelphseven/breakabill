var remain = 0.0;
var last = new Array();
var max_sizes = new Array();
$('body').ready(function()
{
	checkSize();
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
		updateAmount(e);
	});
	$('#save').click(function(e)
	{
		var json = {
			billName : $('#billName').val(),
			billMaker : $('#billMaker').val(),
			makerEmail : $('#makerEmail').val(),
			duedate : $('#datepicker').val(),
			total : ($('#billAmount').val()),
			included : 1,
			people : []
			};
			
		if (isNaN(json.total)) json.total = 0;
		alert(json.total);
		var total = parseInt($('#total-people').val());
		//json.people = new Array();
		var amount = 0;
		for (i=0; i<=total; i++)
		{
			if (parseInt($('#person-deleted-'+i).val()) == 0)
			{
				//json.people[i].push();
				var the_name = $('#person-name-'+i).val();
				var the_email = $('#person-email-'+i).val();
				
				json.people.push( {
					name : the_name,
					email : the_email
				});
					/*
				var temp = new Array();
				temp['name'] = $('#person-name-'+i).val();
				temp['email'] = $('#person-email-'+i).val();
				json['people'][i.toString()] = (temp);
				*/
				amount++;
			}
		}
		var totalamount = amount;
		//if (json['included'] == 1) totalamount++;
		if(json.included == 1) totalamount++;
		//var perperson = json['total'] / totalamount;
		var perperson = json.total / totalamount;
		//alert(json.total + " / " + totalamount + " = " + perperson);
		for (i=0; i<total; i++)
		{
			//json['people'][i.toString()]['amount'] = perperson.toString();
			json.people[i].total = perperson;
		}

		var test = JSON.stringify(json);
		$.ajax({
			url: "../../db/saveBill.php",
			type: "POST",
			data: "data="+test,
			success: function(response)
			{
				alert(response);
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
		makerEmail : $('#makerEmail').val(),
		duedate : $('#datepicker').val(),
		total : ($('#billAmount').val()),
		included : 1,
		people : []
		};
		
	if (isNaN(json.total)) json.total = 0;
	var total = parseInt($('#total-people').val());
	//json.people = new Array();
	var amount = 0;
	for (i=0; i<=total; i++)
	{
		if (parseInt($('#person-deleted-'+i).val()) == 0)
		{
			//json.people[i].push();
			var the_name = $('#person-name-'+i).val();
			var the_email = $('#person-email-'+i).val();
			
			json.people.push( {
				name : the_name,
				email : the_email
			});
				/*
			var temp = new Array();
			temp['name'] = $('#person-name-'+i).val();
			temp['email'] = $('#person-email-'+i).val();
			json['people'][i.toString()] = (temp);
			*/
			amount++;
		}
	}
	var totalamount = amount;
	//if (json['included'] == 1) totalamount++;
	if(json.included == 1) totalamount++;
	//var perperson = json['total'] / totalamount;
	var perperson = json.total / totalamount;
	//alert(json.total + " / " + totalamount + " = " + perperson);
	for (i=0; i<total; i++)
	{
		//json['people'][i.toString()]['amount'] = perperson.toString();
		json.people[i].total = perperson;
	}

	var test = JSON.stringify(json);
	$.ajax({
		url: "../../phpMailer/phpMail.php",
		type: "POST",
		data: "data="+test,
		success: function(response)
		{
			alert(response);
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
	$('#person-slider-'+current).slider({
		change: function(event, ui){checkSlide(event, ui, current)},
		range: "min",
		min: 0,
		max: $('#billAmount').val(),
		step: 0.01
	});
	$('#person-amount-'+current).change(function(e)
	{
		personAmountChange(e, current);
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
function updateAmount(e)
{
	resetAmounts();
	remain = $('#billAmount').val();
	var slider = "#person-slider-";
	var deleted = "#person-deleted-";
	var numsliders = $('#total-people').val();
	var total = remain;
	var percents = new Array();
	for (i=1; i<=numsliders; i++)
	{
		if ($('body').find(deleted+i).val()==0)
		{
			value = "#person-amount-"+i;
			//slidervalue = $('body').find(slider+i).slider("value");
			percents[i] = $(slider+i).slider("value") / $(slider+i).slider("option", "max");
			alert(percents[i]*total);
			//$(slider+i).val(total * percent);
			howmuch = total * percents[i];
			remain -= howmuch;
			//$('body').find(value).val(howmuch);
		}
		
	}
	setMax();
	for (i=1; i<=numsliders; i++)
	{
		if ($('body').find(deleted+i).val()==0)
		{
			$(slider+i).slider("option", "max", total);
			$(slider+i).slider("value", percents[i]*total);
		}
	}
	
}
function resetAmounts()
{
	var slider = "#person-slider-";
	var deleted = "#person-deleted-";
	var amount = "#person-amount-";
	var numsliders = $('#total-people').val();
	var total = $('#billAmount').val();
	var percent_remain = remain / total;
	for (i=1; i<=numsliders; i++)
	{

	}
}
function setMax()
{
	var slider = "#person-slider-";
	var deleted = "#person-deleted-";
	var numsliders = $('#total-people').val();
	var total = $('#billAmount').val();
	//alert(percent_remain);
	for (i=1; i<=numsliders; i++)
	{
		if ($('body').find(deleted+i).val()==0)
		{
			//$('body').find(slider+i).slider("max", $('body').find(slider+i).slider("value") + percent_remain);
			//$('body').find("person-email-"+i).val($('body').find(slider+i).slider("value") + percent_remain*1000000);
			max_sizes[i] = $('body').find(slider+i).slider("value") + remain;
		}
	}
}
function personAmountChange(event, number)
{
	var slider = "#person-slider-"+number;
	var value = "#person-amount-"+number;
	var total = $('#billAmount').val();
	var amount = parseInt($(value).val());
	//var last_amount = total * (last[number]/1000000);
	if (isNaN($(value).val()) || $(value).val() < 0)
	{
		return;
	}
	
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
			remain -= (amount - last_amount);
			last[number] = amount;
			$(slider).slider("value", amount);
			setMax();
		}
	}
	else
	{
	}
}
function checkSlide(event, ui, number)
{
	var slider = "#person-slider-"+number;
	var value = "#person-amount-"+number;
	var total = $('#billAmount').val();
	var slidervalue = $('body').find(slider).slider("value");
	if (max_sizes[number] == null) max_sizes[number] = remain;
	if (slidervalue > last[number])
	{
		if (slidervalue > max_sizes[number])
		{
			$('body').find(slider).slider("value", max_sizes[number]);
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
}