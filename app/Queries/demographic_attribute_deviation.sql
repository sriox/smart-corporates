WITH attribute_results AS (
	SELECT
		r.poll_instance_id AS poll_instance_id,
		r.{{$var}}_id,
		r.{{$var}},
		r.Person AS Person,
		r.attribute_id,
		r.attribute_name,
		sum(r.poll_answer_value) AS value
	FROM
		v_results r
	WHERE (r.attribute_name IS NOT NULL)
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}},
	r.Person,
    r.attribute_id,
	r.attribute_name
)
SELECT
	r.poll_instance_id AS poll_instance_id,
	r.{{$var}}_id as `group_id`,
	r.{{$var}} as `group`,
	r.attribute_id AS attribute_id,
	r.attribute_name AS attribute,
	std(r.value) AS deviation
FROM
	attribute_results r
WHERE r.poll_instance_id = ?
GROUP BY
	r.poll_instance_id,
	r.{{$var}}_id,
	r.{{$var}},
	r.attribute_id,
	r.attribute_name
