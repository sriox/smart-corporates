import { Config, InputParams, Router } from 'ziggy-js'

declare global {
    // declare interface ZiggyLaravelRoutes extends LaravelRoutes {}
    declare function route(routeName: string, params?: Record<string, any>): Router
    // declare function route<RouteKey extends keyof LaravelRoutes>(
    //     name: RouteKey,
    //     params?: LaravelRoutes[RouteKey],
    //     absolute?: boolean,
    //     customZiggy?: Config
    // ): string
}
