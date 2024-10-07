<?php

namespace App\Services\SessionStorageHandlers;

use App\Models\Setting;

class MealsSessionStorageService
{
    public const MEALS_SELECTION_SESSION_KEY = 'meal-ids-selection';

    public const MEALS_PORTION_SIZE_SESSION_KEY = 'meals-portion-size';

    /**
     * @param int $mealId
     * @param int $mealNumber
     * @param string|null $key
     * @return bool
     */
    public static function pushId(int $mealId, int $mealNumber, ?string $key = null): bool
    {
        $sessionKey = self::prepareSessionKey($mealNumber);

        if (!empty($key)) {
            $sessionKey = "$sessionKey.$key";
        }

        session()->push($sessionKey, $mealId);

        return true;
    }

    /**
     * @param int $mealId
     * @param int $mealNumber
     * @param string|null $key
     * @return bool
     */
    public static function forgetId(int $mealId, int $mealNumber, ?string $key = null): bool
    {
        $sessionKey = self::prepareSessionKey($mealNumber);

        if (!empty($key)) {
            $sessionKey = "$sessionKey.$key";
        }

        $storedMealIds = session()->get($sessionKey, []);

        if (($keyToBeRemoved = array_search($mealId, $storedMealIds)) !== false) {
            unset($storedMealIds[$keyToBeRemoved]);
        }

        session()->put($sessionKey, $storedMealIds);

        return true;
    }

    /**
     * @param int|null $mealNumber
     * @return bool
     */
    public static function forgetAllIds(?int $mealNumber = null): bool
    {
        $sessionKey = $mealNumber !== null ? self::prepareSessionKey($mealNumber) : self::MEALS_SELECTION_SESSION_KEY;

        session()->forget($sessionKey);

        return true;
    }

    /**
     * @param int $mealId
     * @param int $mealNumber
     * @param string|null $key
     * @return bool
     */
    public static function hasId(int $mealId, int $mealNumber, ?string $key = null): bool
    {
        $sessionKey = self::prepareSessionKey($mealNumber);

        if (!empty($key)) {
            $sessionKey = "$sessionKey.$key";
        }

        if (!session()->has($sessionKey)) {
            return false;
        }

        return array_search($mealId, session()->get($sessionKey)) !== false;
    }

    /**
     * @param int|null $mealNumber
     * @param string|null $key
     * @return array
     */
    public static function getIds(?int $mealNumber = null, ?string $key = null): array
    {
        $sessionKey = self::MEALS_SELECTION_SESSION_KEY;

        if (!empty($mealNumber)) {
            $sessionKey = self::prepareSessionKey($mealNumber);
        }

        if (!empty($key)) {
            $sessionKey = "$sessionKey.$key";
        }

        return session()->get($sessionKey) ?? [];
    }

    /**
     * @param int $mealNumber
     * @param string|null $key
     * @return int
     */
    public static function countIds(int $mealNumber, ?string $key = null): int
    {
        $sessionKey = self::prepareSessionKey($mealNumber);

        if (!empty($key)) {
            $sessionKey = "$sessionKey.$key";
        }

        return count(session()->get($sessionKey) ?? []);
    }

    /**
     * @return array
     */
    public static function getPortionSize(): array
    {
        return session()->get(self::MEALS_PORTION_SIZE_SESSION_KEY) ?? Setting::getMealsPortionSizes(true)[0];
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function setPortionSize(array $data): bool
    {
        session()->put(self::MEALS_PORTION_SIZE_SESSION_KEY, $data);

        return true;
    }

    /**
     * @param int $mealNumber
     * @return string
     */
    private static function prepareSessionKey(int $mealNumber): string
    {
        return self::MEALS_SELECTION_SESSION_KEY . '.' . $mealNumber;
    }
}
