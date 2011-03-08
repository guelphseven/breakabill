$('body').ready(function()
{
	$('save').click(function(e)
	{
		var json = new Array();
		json['billName'] = $('#billName').val();
		json['billMaker'] = $('#billMaker').val();
		json['makerEmail'] = $('#makerEmail').val();
		json['duedate'] = $('#datepicker').val();
		json['total'] = parseInt($('#billAmount').val());
		var total = parseInt($('#total-people').val());
		json['people'] = new Array();
		var amount = 0;
		for (i=0; i<total; i++)
		{
			if (parseInt($('#person-deleted-'+i).val()) == 0)
			{
				var temp = new Array();
				temp['name'] = $('#person-name-'+i).val();
				temp['email'] = $('#person-email-'+i).val();
				json['people'][i] = (temp);
				amount++;
			}
		}
		var perperson = json['total'] / amount;
		for (i=0; i<amount; i++)
		{
			json['people'][i]['amount'] = perperson;
		}
		$.ajax({
			url: "submitBill.php",
			type: "POST",
			dataType: "JSON",
			data: "",
			success: function(response)
			{
				
			},
			error: function ()
			{
			}
		});
	});
});
function addPerson()
{
	alert("wee");
	var total = parseInt($("#total-people").val());
	var current = total + 1;
	var put = 
	$('#people').append(" \
	<div class='personcontainer' id='person-container-"+current+"'>\
		<div class='fieldrow'>\
			<div class='leftfield'>Name: </div>\
			<div class='rightfield'><input type='text' class='personinput' name='person-name-"+current+"'/></div>\
		</div>		\
		<div class='fieldrow'>\
			<div class='leftfield'>Email: </div>\
			<div class='rightfield'><input type='text' class='personinput' name='person-email-"+current+"'/></div>\
		</div>\
		<div class='fieldrow'>\
			<button onclick='deletePerson("+current+")'>Delete</button>\
		</div>\
		<div class='rightfield'><input type='hidden' name='person-deleted-"+current+"' id='person-deleted-"+current+"' value='0'/></div>\
	</div>\
	");
	total++;
	$("#total-people").val(total);
}
function deletePerson(num)
{
	$('#person-deleted-'+num).val(1);
	$('#person-container-'+num).hide();
}