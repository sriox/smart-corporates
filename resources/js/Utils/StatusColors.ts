interface RangeColor {
    min: number
    max: number
    color: string
}

export const statusColors: Record<string, string> = {
    success: 'bg-green-200',
    error: 'bg-red-200',
    warning: 'bg-orange-200',
    info: 'bg-blue-200',
}

export const rangeColors: RangeColor[] = [
    { min: 0, max: 30, color: '#fd0100' },
    { min: 30, max: 50, color: '#f76915' },
    { min: 50, max: 70, color: '#ee9b00' },
    { min: 70, max: 85, color: '#eede04' },
    { min: 85, max: 95, color: '#a0d636' },
    { min: 95, max: 1000, color: '#2fa236' },
]

export const enpColors: RangeColor[] = [
    { min: -99, max: 20, color: '#ee9b00' },
    { min: 20, max: 50, color: '#eede04' },
    { min: 50, max: 80, color: '#a0d636' },
    { min: 80, max: 1000, color: '#2fa236' },
]

export function getEnpColor(val: number): string {
    return enpColors.find((item: RangeColor) => val >= item.min && val < item.max)?.color ?? ''
}
