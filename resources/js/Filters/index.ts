export default {
    decimal: (val: number | string, positions: number = 2): number => {
        return parseFloat(parseFloat(val.toString()).toFixed(positions))
    },
}
