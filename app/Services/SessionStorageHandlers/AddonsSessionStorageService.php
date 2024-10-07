<?php

namespace App\Services\SessionStorageHandlers;

class AddonsSessionStorageService
{
    public const ADDON_MEALS_SELECTION_SESSION_KEY = 'addons-selection';
    public const ADDONS_SELECTION_SESSION_KEY = 'addons-added-to-cart';

    /**
     * @param int $addonId
     * @param int $mealId
     * @return bool
     */
    public static function pushId(int $addonId, int $mealId): bool
    {
        session()->push(self::prepareAddonSessionKey($addonId), $mealId);

        return true;
    }

    /**
     * @param int $addonId
     * @return bool
     */
    public static function pushAddonId(int $addonId): bool
    {
        session()->push(self::ADDONS_SELECTION_SESSION_KEY, $addonId);

        return true;
    }

    /**
     * @param int $addonId
     * @param int $mealId
     * @return bool
     */
    public static function forgetId(int $addonId, int $mealId): bool
    {
        $sessionKey = self::prepareAddonSessionKey($addonId);

        $storedMealIds = session()->get($sessionKey, []);

        if (($keyToBeRemoved = array_search($mealId, $storedMealIds)) !== false) {
            unset($storedMealIds[$keyToBeRemoved]);
        }

        session()->put($sessionKey, $storedMealIds);

        return true;
    }

    /**
     * @param int|null $addonId
     * @return bool
     */
    public static function forgetAllIds(?int $addonId = null): bool
    {
        if ($addonId) {
            $sessionKey = self::prepareAddonSessionKey($addonId);
        }

        session()->forget($sessionKey ?? self::ADDON_MEALS_SELECTION_SESSION_KEY);

        return true;
    }

    /**
     * @param int $addonId
     * @return bool
     */
    public static function forgetAddonId(int $addonId): bool
    {
        $storedAddonIds = session()->get(self::ADDONS_SELECTION_SESSION_KEY, []);

        if (($keyToBeRemoved = array_search($addonId, $storedAddonIds)) !== false) {
            unset($storedAddonIds[$keyToBeRemoved]);
        }

        session()->put(self::ADDONS_SELECTION_SESSION_KEY, $storedAddonIds);

        return true;
    }

    /**
     * @param int $addonId
     * @return int
     */
    public static function countIds(int $addonId): int
    {
        return count(session()->get(self::prepareAddonSessionKey($addonId)) ?? []);
    }

    /**
     * @param int|null $addonId
     * @return array|null
     */
    public static function getIds(?int $addonId = null): ?array
    {
        if ($addonId) {
            return session()->get(self::prepareAddonSessionKey($addonId));
        }

        return session()->get(self::ADDON_MEALS_SELECTION_SESSION_KEY);
    }

    /**
     * @return array|null
     */
    public static function getAddonIds(): ?array
    {
        return session()->get(self::ADDONS_SELECTION_SESSION_KEY);
    }

    /**
     * @param int $addonId
     * @return bool
     */
    public static function hasAddonId(int $addonId): bool
    {
        $storedAddonIds = session()->get(self::ADDONS_SELECTION_SESSION_KEY, []);

        return in_array($addonId, $storedAddonIds);
    }

    /**
     * @param int $addonId
     * @return string
     */
    private static function prepareAddonSessionKey(int $addonId): string
    {
        return self::ADDON_MEALS_SELECTION_SESSION_KEY . '.' . $addonId;
    }
}
