SELECT
	att.name as `attribute`,
	AVG(a. `value`) / 5 * 100 AS result
FROM
	participant_poll_answers pa,
	poll_answers a,
	questions q,
	poll_instances pi,
	participants p,
	people pe,
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
    AND p.finish_at is not null
GROUP BY
	attribute
ORDER BY result DESC
limit 6
