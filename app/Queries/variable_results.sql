with factors as (
SELECT r.poll_instance_id, r.{{$var}}_id, r.question_id, r.{{$var}}, r.question_variable, count(0) as `count`, mv.max_value, count(0) * mv.max_value as `factor`
FROM v_results r, v_max_answer_values mv
WHERE mv.poll_instance_id = r.poll_instance_id
and r.dimension_id is not null
GROUP by r.poll_instance_id, r.{{$var}}_id, r.question_id, r.{{$var}}, r.question_variable, mv.max_value)
SELECT r.poll_instance_id, r.{{$var}}_id as group_id, r.question_id, r.{{$var}} as `group`, r.question_variable, sum(r.poll_answer_value) as `value`, f.factor, sum(r.poll_answer_value) / f.factor * 100 as `result`
FROM v_results r, factors f
WHERE r.poll_instance_id = ?
and f.poll_instance_id = r.poll_instance_id
and f.{{$var}}_id = r.{{$var}}_id
and f.question_id = r.question_id
group by r.poll_instance_id, r.{{$var}}_id, r.question_id, r.{{$var}}, r.question_variable, f.factor
