WITH factors AS (
	SELECT
		r.poll_instance_id,
		r.{{$var}}_id,
		r.{{$var}},
		count(0) AS `count`,
		mv.max_value,
		count(0) * mv.max_value AS `factor`
	FROM
		v_results r,
		v_max_answer_values mv
	WHERE
		mv.poll_instance_id = r.poll_instance_id
		AND r.question_group = 'engagement'
	GROUP BY
		r.poll_instance_id,
		r.{{$var}}_id,
		r.{{$var}},
		mv.max_value
)
SELECT
	r.poll_instance_id,
	r.{{$var}}_id AS group_id,
	r.{{$var}} AS `group`,
	sum(r.poll_answer_value) AS `value`,
	f.factor,
	sum(r.poll_answer_value) / f.factor * 100 AS `result`
FROM
	v_results r,
	factors f
WHERE
	r.poll_instance_id = ?
	AND f.poll_instance_id = r.poll_instance_id
	AND f.{{$var}}_id = r.{{$var}}_id
	AND r.question_group = 'engagement'
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}},
	f.factor
