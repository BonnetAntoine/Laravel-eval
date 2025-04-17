<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

if (! function_exists('secureEncode64')) { // @codeCoverageIgnore
    /**
     * Génère une clef encodée base 64 avec un sel associé à la clef de l'application
     *
     * @param  string  $data
     *
     * @return string
     */
    function secureEncode64(string $data)
    {
        return base64_encode($data . env('APP_KEY'));
    }
}

if (! function_exists('format_currency')) { // @codeCoverageIgnore
    /**
     * Renvoie la valeur formatée avec les paramètres souhaités
     *
     * @param  float  $value
     * @param  string  $currency
     * @param  string  $locale
     *
     * @return string|false
     */
    function format_currency(float $value, string $currency = 'EUR', string $locale = 'fr_FR')
    {
        $fmt = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $fmt->formatCurrency($value, $currency);
    }
}

if (! function_exists('format_number')) { // @codeCoverageIgnore
    /**
     * Renvoie la valeur formatée avec les paramètres souhaités
     *
     * @param  mixed  $value
     * @param  int  $mode
     * @param  string  $locale
     * @param  string  $pattern
     *
     * @return string
     */
    function format_number($value, int $mode = NumberFormatter::DECIMAL_ALWAYS_SHOWN, string $locale = 'fr_FR', string $pattern = '#,##0.00'): string
    {
        $fmt = new NumberFormatter($locale, $mode);
        $fmt->setPattern($pattern);

        return $fmt->format($value);        // @phpstan-ignore-line
    }
}

/**
 * Format français étendu ddddd DD MMMM YYYY
 */
if (! function_exists('format_date')) { // @codeCoverageIgnore
    /**
     * Renvoie la valeur formatée avec les paramètres souhaités
     *
     * @param  ?string  $date  Date qui sera parsée
     * @param  string  $format  Format de sortie, par défaut DD/MM/YYYY
     *
     * @return ?string Date au $format
     */
    function format_date(?string $date, string $format = 'DD/MM/YYYY', ?string $timezone = null): ?string
    {
        if ($date === null) {
            return null;
        }

        if ($timezone === null) {
            $timezone = config('app.timezone');
        }

        $date = \Carbon\Carbon::parse($date, $timezone)->locale('fr_FR');

        return $date->isoFormat($format);       // @phpstan-ignore-line
    }
}

if (! function_exists('format_hour')) { // @codeCoverageIgnore
    /**
     * Renvoie la valeur formatée avec les paramètres souhaités
     *
     * @param  ?string  $hour  Heure qui sera parsée
     *
     * @return ?string Date au $format
     */
    function format_hour(?string $hour): ?string
    {
        if ($hour === null) {
            return null;
        }

        $tmp = explode(':', $hour);

        return count($tmp) > 2
            ? implode(':', array_slice($tmp, 0, 2))
            : $hour;
    }
}

if (! function_exists('format_telephone')) { // @codeCoverageIgnore
    function format_telephone(?string $value = null)
    {
        if ($value === null) {
            return null;
        }

        // NB : ce n'est pas un espace mais un blanc non sécable
        return rtrim(chunk_split($value, 2, ' '), ' ');
    }
}

if (! function_exists('format_siret')) { // @codeCoverageIgnore
    function format_siret(?string $value = null)
    {
        if ($value === null) {
            return null;
        }

        // NB : ce n'est pas un espace mais un blanc non sécable
        return chunk_split(substr($value, 0, 9), 3, ' ') . substr($value, -5);
    }
}

if (! function_exists('format_date_FrToEng')) { // @codeCoverageIgnore
    /**
     * Renvoie une date au format anglais à partir d'une date au format français
     *
     * @param  ?string  $date  Date au format JJ/MM/AAAA soit d/m/Y
     *
     * @return ?string Date au format AAAA-MM-JJ soit Y-m-d
     */
    function format_date_FrToEng(?string $date): ?string
    {
        if ($date === null) {
            return null;
        }

        return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');       // @phpstan-ignore-line
    }
}

if (! function_exists('nbDaysBetween')) { // @codeCoverageIgnore
    /**
     * Revoie le nombre de jours entre 2 dates
     *
     * @param  string  $start_date
     * @param  string  $end_date
     * @param  bool  $include
     *
     * @see https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
     *
     * @return int
     */
    function nbDaysBetween(string $start_date, string $end_date, $include = false): int
    {
        $earlier = new DateTime($start_date);
        $later = new DateTime($end_date);

        return (int) $later->diff($earlier)->format('%a') + ($include ? 1 : 0);
    }
}

if (! function_exists('nbDaysOffBetween')) { // @codeCoverageIgnore
    /**
     * Revoie le nombre de jours entre 2 dates hors les weekends
     *
     * @param  string  $start_date
     * @param  string  $end_date
     * @param  bool  $include
     *
     * @see https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
     *
     * @return int
     */
    function nbDaysOffBetween(string $start_date, string $end_date): int
    {
        $earlier = Carbon::parse($start_date);
        $later = Carbon::parse($end_date);

        return (int) $earlier->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekend();
        }, $later);
    }
}

if (! function_exists('sizeFileReadable')) { // @codeCoverageIgnore
    /**
     * Renvoie le poids d'un fichier exprimés en bytes dans un format compréhensible pour un humain
     *
     * @float mixed $bytes
     *
     * @return string
     */
    function sizeFileReadable(float $bytes)
    {
        if ($bytes < 1) {
            return '0 B';
        }

        $i = floor(log($bytes, 1024));

        return (string) round($bytes / pow(1024, $i), [0, 0, 2, 2, 3][$i]) . ['B', 'kB', 'MB', 'GB', 'TB'][$i];
    }
}

if (! function_exists('sanitizeFloat')) { // @codeCoverageIgnore
    /**
     * Renvoie une valeur numérique brute sans caractères de mises en forme
     *
     * @param  string|null  $input  Entrant dont il faut supprimer les décorations
     *
     * @return float Revoie la valeur sans décoration ou 0 si la valeur vaut null
     *
     * @see https://www.php.net/manual/fr/function.floatval.php#114486
     */
    function sanitizeFloat(?string $input): float
    {
        if ($input === null) {
            return 0.0;
        }

        $dotPos = strrpos($input, '.');
        $commaPos = strrpos($input, ',');
        $sep = $dotPos > $commaPos && $dotPos ? $dotPos : ($commaPos > $dotPos && $commaPos ? $commaPos : false);

        if (! $sep) {
            return floatval(preg_replace('/[^0-9\-]/', '', $input));
        }

        return floatval(
            preg_replace('/[^0-9\-]/', '', substr($input, 0, $sep)) . '.' .
                preg_replace('/[^0-9\-]/', '', substr($input, $sep + 1, strlen($input)))
        );
    }
}

if (! function_exists('supprimer_decoration')) { // @codeCoverageIgnore
    /**
     * @param  string|null  $input  Entrant dont il faut supprimer les décorations
     *
     * @return string Revoie la valeur sans décoration ou 0 si la valeur vaut null
     *
     * @see https://www.php.net/manual/fr/function.floatval.php#114486
     */
    function supprimer_decoration(?string $input): string
    {
        if ($input === null) {
            return 0;
        }

        $dotPos = strrpos($input, '.');
        $commaPos = strrpos($input, ',');
        $sep = $dotPos > $commaPos && $dotPos ? $dotPos : ($commaPos > $dotPos && $commaPos ? $commaPos : false);

        if (! $sep) {
            return floatval(preg_replace('/[^0-9\-]/', '', $input));
        }

        return floatval(
            preg_replace('/[^0-9\-]/', '', substr($input, 0, $sep)) . '.' .
                preg_replace('/[^0-9\-]/', '', substr($input, $sep + 1, strlen($input)))
        );
    }
}

if (! function_exists('bool_val')) { // @codeCoverageIgnore
    /**
     * Renvoie un booléen en fonction du paramètre passé
     *
     * @param  mixed  $input
     *
     * @return bool
     */
    function bool_val(mixed $input): bool
    {
        if (! is_string($input)) {
            return (bool) $input;
        }
        switch (strtolower($input)) {
            case '1':
            case 'true':
            case 'on':
            case 'yes':
            case 'y':
                return true;
            default:
                return false;
        }
    }
}

if (! function_exists('salaries')) { // @codeCoverageIgnore
    /**
     * @return Collection<string|int, User>
     *
     * @throws InvalidArgumentException
     * @throws BadRequestException
     */
    function salaries()
    {
        if (Auth::check() && Auth::user()->isA('admin')) {
            return User::whereIs('salarie')->get();
        }

        return collect([]);
    }
}

if (! class_exists('BreadcrumbItem')) { // @codeCoverageIgnore
    class BreadcrumbItem
    {
        /**
         * @param  string  $libelle  Libellé
         * @param  string  $lien  Lien associé, # par défaut
         * @param  bool  $isActive  Indique si le lien la page active, false par défaut
         *
         * @return void
         */
        public function __construct(public string $libelle, public string $lien = '#', public bool $isActive = false)
        {
        }
    }
}

if (! class_exists('DateUSGPH')) { // @codeCoverageIgnore
    class DateUSGPH
    {
        /**
         * Summary of getUSGPHYear
         *
         * @param  \Carbon\Carbon|null  $currentDay
         *
         * @return array
         */
        public static function getUSGPHYear(?Carbon $currentDay = null)
        {
            if ($currentDay === null) {
                $currentDay = Carbon::now();
            } elseif ($currentDay instanceof \Carbon\Carbon) {
                $currentDay = Carbon::parse($currentDay);
            } elseif (! $currentDay instanceof Carbon) {
                $currentDay = Carbon::parse($currentDay);
            }
            $currentYear = $currentDay->year;

            if ($currentDay->gte(Carbon::create($currentYear, 9, 1))) {
                return [
                    'start' => Carbon::create($currentYear, 9, 1, 0, 0, 0),
                    'end' => Carbon::create($currentYear + 1, 8, 31, 23, 59, 59),
                ];
            }

            return [
                'start' => Carbon::create($currentYear - 1, 9, 1, 0, 0, 0),
                'end' => Carbon::create($currentYear, 8, 31, 23, 59, 59),
            ];
        }
    }
}
