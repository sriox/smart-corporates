<template>
    <div class="rounded-xl uppercase border-2 inline-block mx-2 px-5 py-8 text-gray-900 drop-shadow-lg" :class="getRangeColor()">
        <div class="indicator-name font-semibold text-center mb-4">
            {{ name }}
        </div>
        <div class="indicator-value flex justify-center text-3xl text-gray-900">
            <slot> {{ value }}{{ symbol }} </slot>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue'

const props = defineProps({
    name: {
        type: String,
    },
    value: {
        type: [Number, String],
        default: -1,
    },
    symbol: {
        type: String,
        default: '%',
    },
})

const getRangeColor = () => {
    const def = 'border-gray-900 bg-gray-800'
    if (-1 === props.value) return def
    const ranges = [
        { min: 0, max: 20, classes: 'range1' },
        { min: 20, max: 50, classes: 'range2' },
        { min: 50, max: 80, classes: 'range3' },
        { min: 80, max: 100, classes: 'range4' },
    ]

    const val = parseFloat(props.value)
    const range = ranges.find((item) => val >= item.min && val < item.max)
    return range?.classes || def
}
</script>
<style scoped>
.range1 {
    background-color: #ee9b00;
}
.range2 {
    background-color: #eede04;
}
.range3 {
    background-color: #a0d636;
}
.range4 {
    background-color: #2fa236;
}
</style>
