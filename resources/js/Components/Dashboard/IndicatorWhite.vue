<template>
    <div class="rounded-xl uppercase border-2 inline-block mx-2 px-5 py-8 drop-shadow-lg text-white" :class="getRangeColor()">
        <div class="indicator-name font-semibold text-center mb-4">
            {{ name }}
        </div>
        <div class="indicator-value flex justify-center text-3xl text-white">
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
    textLight: {
        type: Boolean,
        default: false,
    },
})

const getRangeColor = () => {
    const def = 'border-gray-900 bg-gray-800'
    if (-1 === props.value) return def
    const ranges = [
        { min: 0, max: 30, classes: 'range1' },
        { min: 30, max: 50, classes: 'range2' },
        { min: 50, max: 70, classes: 'range3' },
        { min: 70, max: 85, classes: 'range4' },
        { min: 85, max: 95, classes: 'range5' },
        { min: 95, max: 1000, classes: 'range6' },
    ]

    const val = parseFloat(props.value)
    const range = ranges.find((item) => val >= item.min && val < item.max)
    const classes = range?.classes || def
    return classes
}
</script>
<style scoped>
.range1 {
    background-color: #fd0100;
}
.range2 {
    background-color: #f76915;
}
.range3 {
    background-color: #ee9b00;
}
.range4 {
    background-color: #eede04;
}
.range5 {
    background-color: #a0d636;
}
.range6 {
    background-color: #2fa236;
}
</style>
