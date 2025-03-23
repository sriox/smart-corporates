WITH variable_results AS (
	SELECT
		r.poll_instance_id AS poll_instance_id,
		r.{{$var}}_id,
		r.{{$var}},
		r.Person AS Person,
		r.question_id,
		r.question_variable,
		r.poll_answer_value AS value
	FROM
		v_results r
	WHERE (r.question_variable IS NOT NULL)
)
SELECT
	r.poll_instance_id,
	r.{{$var}}_id as `group_id`,
	r.{{$var}} as `group`,
	r.question_id,
	r.question_variable AS variable,
	std(r.value) AS deviation
FROM
	variable_results r
WHERE r.poll_instance_id = ?
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}},
	r.question_id,
	r.question_variable
