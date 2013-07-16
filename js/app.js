var reportCount = 0;


$('#add-report').click(function () {
	var template = $('#form-fields').clone();
	reportCount++;

	var attendee = template.clone().find(':input, textarea').each(function (fo) {
		var name = this.name.substring(0, 7) + reportCount + this.name.substring(8, this.name.length);
		var id = name.replace(/\[/g, '').replace(/\]/g, '');

		this.name = name;
		this.id = id;
	}).end()
		.find('.count').each(function (fo) {
			$(this).html(reportCount);
		}).end()
		.find('label[for]').each(function (fo) {
			var oldLabel = $(this).attr('for');
			$(this).attr('for', oldLabel.substring(0, 6) + reportCount + oldLabel.substring(7, oldLabel.length));
		}).end()
		.attr('id', 'att' + reportCount)
		.appendTo('#reports');
});

$('#form').submit(function (e) {
	e.preventDefault();

	$.ajax({type: 'POST', url: 'ajax.php', data: $('#form').serialize(),
		success: function (response) {
			$('#result').html(response);
		}
	});
});

$("#form").delegate(".delete", "click", function () {
	$(this).parents('fieldset').remove();
});