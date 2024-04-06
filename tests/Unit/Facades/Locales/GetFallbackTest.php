<?php

/**
 * This file is part of the "laravel-lang/locales" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;

it('returns English locale as a fallback', function () {
    expect(Locales::getFallback()->code)
        ->toBe(Locale::English->value);
});

it('returns German locale as a fallback', function () {
    setLocales(fallback: Locale::German);

    expect(Locales::getFallback()->code)
        ->toBe(Locale::German->value);
});

it('returns English locale if the fallback one is specified incorrectly', function () {
    setLocales(fallback: 'foo');

    expect(Locales::getFallback()->code)
        ->toBe(Locale::English->value);
});

it('returns German locale if the fallback is invalid', function () {
    setLocales(Locale::German, 'foo');

    expect(Locales::getFallback()->code)
        ->toBe(Locale::German->value);
});

it('returns the main localization if the spare is null', function () {
    setLocales(Locale::German, null);

    expect(Locales::getFallback()->code)
        ->toBe(Locale::German->value);
});

it('returns the English locale if both are set to null', function () {
    setLocales(null, null);

    expect(Locales::getFallback()->code)
        ->toBe(Locale::English->value);
});

it('returns English locale if both are invalid', function () {
    setLocales('foo', 'foo');

    expect(Locales::getFallback()->code)
        ->toBe(Locale::English->value);
});

it('will return the locale by alias', function (Locale $locale, string $alias) {
    setLocales(fallback: $locale);

    setAlias($locale, $alias);

    expect(Locales::getFallback()->code)
        ->toBe($alias)
        ->not->toBe($locale->value);
})->with('aliased-locales');

it('checks for missing currency information')
    ->expect(fn () => Locales::getFallback(withCurrency: false))
    ->country->not->toBeNull()
    ->currency->toBeNull();

it('checks for missing country information')
    ->expect(fn () => Locales::getFallback(withCountry: false))
    ->country->toBeNull()
    ->currency->not->toBeNull();

it('checks for missing country and currency information')
    ->expect(fn () => Locales::getFallback(false, false))
    ->country->toBeNull()
    ->currency->toBeNull();

it('returns the correct localized name if the non-default locale is set', function () {
    createLocales(Locale::German, Locale::English);
    setLocales(fallback: Locale::German);

    Locales::set(Locale::English);

    expect(Locales::getFallback())
        ->localized->toBeString()->toBe('German');

    Locales::set(Locale::German);

    expect(Locales::getFallback())
        ->localized->toBeString()->toBe('Deutsch');
});
