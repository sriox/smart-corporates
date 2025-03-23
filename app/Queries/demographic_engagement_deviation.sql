WITH engagement_results AS (
	SELECT
		r.poll_instance_id,
		r.{{$var}}_id,
		r.{{$var}},
		r.Person AS Person,
		sum(r.poll_answer_value) AS value
	FROM
		v_results r
	WHERE (r.question_group = 'engagement')
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}},
	r.Person
)
SELECT
	r.poll_instance_id AS poll_instance_id,
	r.{{$var}}_id as `group_id`,
	r.{{$var}} as `group`,
	std(r.value) AS deviation
FROM
	engagement_results r
WHERE r.poll_instance_id = ?
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}}
ORDER BY
	r.{{$var}}
