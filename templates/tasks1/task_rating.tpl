<div class="task_rating_block">
������ �������� ������: <select id="task_rating_select_{TASK_ID}" onchange="Tasks.edit_task_rating('{TASK_ID}', $(this).val())" class="input_text">
<option id="0">�� �������</option>
{RATING_LIST}
</select><span id="task_rating_{TASK_ID}" class="task_quality_proc"></span>
</div>