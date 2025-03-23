WITH dimension_results AS (
	SELECT
		r.poll_instance_id,
		r.{{$var}}_id,
		r.{{$var}},
		r.Person AS Person,
		r.dimension_id,
		r.dimension,
        r.dimension_order,
		sum(r.poll_answer_value) AS value
	FROM
		v_results r
	WHERE (r.dimension IS NOT NULL)
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}},
	r.Person,
    r.dimension_id,
    r.dimension,
	r.dimension_order
)
SELECT
	r.poll_instance_id AS poll_instance_id,
	r.{{$var}}_id as `group_id`,
	r.{{$var}} as `group`,
	r.dimension_id AS dimension_id,
	r.dimension AS dimension,
	std(r.value) AS deviation
FROM
	dimension_results r
WHERE r.poll_instance_id = ?
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}},
	r.dimension_id,
	r.dimension
ORDER BY
	r.{{$var}}, dimension
