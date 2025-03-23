<template>
    <div class="bg-white py-1 px-4 max-w-full">
        <div class="grid-cols-1">
            <div class="flex justify-end py-1">
                <slot name="buttons"></slot>
            </div>
        </div>
        <table class="table w-full border">
            <thead>
                <tr class="bg-gray-600 text-white font-bold">
                    <th v-for="(column, index) in columns" :key="`header-${index}`" class="border">
                        {{ column.text }}
                    </th>
                </tr>
                <!-- <tr>
                    <th v-for="(column, index) in columns" :key="`header-${index}`" class="border">
                        <slot :name="`header(${column.key})`" v-bind="column"></slot>
                    </th>
                </tr> -->
            </thead>
            <tbody>
                <tr v-for="(item, i) in theItems" :key="`row-${i}`" :class="getClasses(item)">
                    <td v-for="(column, j) in columns" :key="`row-${i}-col-${j}`" class="border border-gray-800 px-2 py-2" :class="compact ? 'py-0' : 'py-2'">
                        <div :class="column.classes || ''">
                            <slot :name="`cell(${column.key})`" v-bind="{ item, row: i, col: j }">
                                {{ getValue(item, column.key) }}
                            </slot>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import { computed } from '@vue/reactivity'
import { ref, toRefs } from 'vue'

const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        default: () => [],
    },
    resource: {
        type: String,
    },
    mutator: {
        type: Function,
    },
    sorter: {
        type: Function,
    },
    compact: {
        type: Boolean,
        default: false,
    },
})

const { columns, items, resoucer } = toRefs(props)
const getValue = (obj, key) => {
    return _.get(obj, key)
}

const theItems = computed(() => {
    let _items = typeof props.mutator !== 'function' ? props.items : props.items.map((item) => props.mutator(item))

    _items = typeof props.sorter === 'function' ? props.sorter(_items) : _items

    return _items
})

const getClasses = (item) => {
    if (Array.isArray(item.rowClasses)) return item.rowClasses.join(' ')
    return item.rowClasses || ''
}
</script>
