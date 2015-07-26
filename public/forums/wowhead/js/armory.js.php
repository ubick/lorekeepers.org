<?php
header('Content-Type: application/x-javascript', true);
$armory_self_dir = dirname(dirname($_SERVER['PHP_SELF']));
?>

var armory_self_dir = '<?php print $armory_self_dir; ?>';

<?php
foreach (array (
				'jquery-1.3.2.min.js',
				'jquery.cluetip.js') as $f) {
	print file_get_contents ($f);
}
?>

$(document).ready(function () {
	$('.armory_tip').cluetip ({
		showTitle: false,
		dropShadow: false,
		tracking: true,
		fx: {
			open: 'fadeIn'
		}
	});
	
	$('a.zone_tip').cluetip({
		showTitle: false,
		dropShadow: false,
		tracking: true,
		fx:
		{
			open: 'fadeIn'
		}
	});
	
	$('a.faction_tip').cluetip({
		showTitle: false,
		dropShadow: false,
		tracking: true,
		width: '500px',
		fx:
		{
			open:	'fadeIn'
		}
	});
	
	$('a.toggle_enchant').click(function(e)
	{
		$(e.target).next('div.enchantToggle').toggle();
	});
	
	$('a.toggle_craft').click(function(e)
	{
		$(e.target).next('div.craftToggle').toggle();
	});
	
	$('a.toggle_itemset').click(function(e)
	{
		$(e.target).next('div.itemsetToggle').toggle();
	});
	
	$("div.gearListToggle").hide();
	
	$('a.faction_rewards').click(function(e)
	{
		$(e.target).next('div.factionToggle').toggle();
		if ($(e.target).next('div.factionToggle').is(':visible'))
		{
			var title = $(e.target).attr('title');
			var rn = title.split(':', 3); 
			$.ajax({
				type: "GET",
				url: armory_self_dir + "/external/faction.php",
				data: "id=" + rn[0] + "&lang=" + rn[1] + "&mode=" + rn[2],
				cache: false,
				success: function(thedata) {
					$(e.target).next('div.factionToggle').html(thedata);
				}
			});
		}
	});

	$("a.armory_gearlist").click(function(e)
	{
		$(e.target).next("div.gearListToggle").toggle();
		if( $(e.target).next('div.gearListToggle').is(':visible') ) {
		    var title = $(e.target).attr('title');
			var rn = title.split(':', 3);
			$.ajax({
				type: "GET",
				url: armory_self_dir + "/external/gearlist.php",
				data: "region=" + rn[0] + "&realm=" + rn[1] + "&name=" + rn[2],
				cache: false,
				success: function(newdata){
					$(e.target).next('div.gearListToggle').html(newdata);
				}
			});
		}
	});
	
	$('a.armory_recruit').click(function()
	{
		$('div.recruitToggle').toggle();
	});
	
	$('#recruitSelect').change(function()
	{
	
		var title = $('#recruitSelect').attr('title');
		var rn = title.split(':', 3);
		var value = $('option:selected', this).val()
		if (value != 'null')
		{
			$('div.recruitContainer').show();
			$('div.recruitContainer').html('Please wait...gathering data...');
			$.ajax({
				type:		'GET',
				url:		armory_self_dir + '/external/recruit.php',
				data:		'mode=' + value + '&region=' + rn[0] + '&realm=' + rn[1] + '&name=' + rn[2],
				cache:		false,
				success:	function(newdata) {
					$('div.recruitContainer').html(newdata);
				}
			});
		}
		else
		{
			$('div.recruitContainer').html('Please wait...gathering data...');
			$('div.recruitContainer').hide();
		}
	});
	
	$("input[name$='toggle_talents']").live('click', function()
	{
		if ( $(this).val() == 1 )
		{
			// toggle the values in the headers
			$('#treeOneToggle1').addClass('talent-shown');
			$('#treeOneToggle1').removeClass('talent-hidden');
			$('#treeTwoToggle1').addClass('talent-shown');
			$('#treeTwoToggle1').removeClass('talent-hidden');
			$('#treeThreeToggle1').addClass('talent-shown');
			$('#treeThreeToggle1').removeClass('talent-hidden');
			
			$('#treeOneToggle2').addClass('talent-hidden');
			$('#treeOneToggle2').removeClass('talent-shown');
			$('#treeTwoToggle2').addClass('talent-hidden');
			$('#treeTwoToggle2').removeClass('talent-shown');
			$('#treeThreeToggle2').addClass('talent-hidden');
			$('#treeThreeToggle2').removeClass('talent-shown');
			
			// now toggle the spells
			$('#treeOneFirst').show();
			$('#treeOneSecond').hide();
			$('#treeTwoFirst').show();
			$('#treeTwoSecond').hide();
			$('#treeThreeFirst').show();
			$('#treeThreeSecond').hide();
			
			// finally the glyphs
			$('#glyphOne').show();
			$('#glyphTwo').hide();
		}
		else if ( $(this).val() == 2 )
		{
			// toggle the values in the headers
			$('#treeOneToggle1').addClass('talent-hidden');
			$('#treeOneToggle1').removeClass('talent-shown');
			$('#treeTwoToggle1').addClass('talent-hidden');
			$('#treeTwoToggle1').removeClass('talent-shown');
			$('#treeThreeToggle1').addClass('talent-hidden');
			$('#treeThreeToggle1').removeClass('talent-shown');
			
			$('#treeOneToggle2').addClass('talent-shown');
			$('#treeOneToggle2').removeClass('talent-hidden');
			$('#treeTwoToggle2').addClass('talent-shown');
			$('#treeTwoToggle2').removeClass('talent-hidden');
			$('#treeThreeToggle2').addClass('talent-shown');
			$('#treeThreeToggle2').removeClass('talent-hidden');
			
			// now toggle the spells
			$('#treeOneFirst').hide();
			$('#treeOneSecond').show();
			$('#treeTwoFirst').hide();
			$('#treeTwoSecond').show();
			$('#treeThreeFirst').hide();
			$('#treeThreeSecond').show();
			
			// finally the glyphs
			$('#glyphOne').hide();
			$('#glyphTwo').show();	
		}
	});
});
