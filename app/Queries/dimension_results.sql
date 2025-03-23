with factors as (
SELECT r.poll_instance_id, r.{{$var}}_id, r.dimension_id, r.{{$var}}, r.dimension, count(0) as `count`, mv.max_value, count(0) * mv.max_value as `factor`
FROM v_results r, v_max_answer_values mv
WHERE mv.poll_instance_id = r.poll_instance_id
and r.dimension_id is not null
GROUP by r.poll_instance_id, r.{{$var}}_id, r.dimension_id, r.{{$var}}, r.dimension, mv.max_value)
SELECT r.poll_instance_id, r.{{$var}}_id as group_id, r.dimension_id, r.{{$var}} as `group`, r.dimension, sum(r.poll_answer_value) as `value`, f.factor, sum(r.poll_answer_value) / f.factor * 100 as `result`
FROM v_results r, factors f
WHERE r.poll_instance_id = ?
and f.poll_instance_id = r.poll_instance_id
and f.{{$var}}_id = r.{{$var}}_id
and f.dimension_id = r.dimension_id
group by r.poll_instance_id, r.{{$var}}_id, r.dimension_id, r.{{$var}}, r.dimension, f.factor
