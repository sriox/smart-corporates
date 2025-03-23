-- Results by Dimension, attribute and variable
SELECT
	d.id as dimension_id,
	d.name as dimension,
	att.name as `attribute`,
	q.variable,
	AVG(a. `value`) / 5 * 100 AS result
FROM
	participant_poll_answers pa,
	poll_answers a,
	questions q,
	poll_instances pi,
	participants p,
	people pe,
	dimensions d,
	`attributes` att
WHERE
	pi.id = ?
	AND p.poll_instance_id = pi.id
	AND pa.participant_id = p.id
	AND a.id = pa.poll_answer_id
	AND q.id = pa.question_id
	AND pe.id = p.person_id
	AND pe.deleted_at IS NULL
	AND att.id = q.attribute_id
	AND d.id = att.dimension_id
    AND p.finish_at is not null
GROUP BY
	dimension_id, dimension, attribute, q.variable
ORDER BY dimension_id, dimension, attribute
