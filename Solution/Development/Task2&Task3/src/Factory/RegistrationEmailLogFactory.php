<?php

namespace App\Factory;

use App\Entity\RegistrationEmailLog;
use App\Repository\RegistrationEmailLogRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<RegistrationEmailLog>
 *
 * @method        RegistrationEmailLog|Proxy                     create(array|callable $attributes = [])
 * @method static RegistrationEmailLog|Proxy                     createOne(array $attributes = [])
 * @method static RegistrationEmailLog|Proxy                     find(object|array|mixed $criteria)
 * @method static RegistrationEmailLog|Proxy                     findOrCreate(array $attributes)
 * @method static RegistrationEmailLog|Proxy                     first(string $sortedField = 'id')
 * @method static RegistrationEmailLog|Proxy                     last(string $sortedField = 'id')
 * @method static RegistrationEmailLog|Proxy                     random(array $attributes = [])
 * @method static RegistrationEmailLog|Proxy                     randomOrCreate(array $attributes = [])
 * @method static RegistrationEmailLogRepository|RepositoryProxy repository()
 * @method static RegistrationEmailLog[]|Proxy[]                 all()
 * @method static RegistrationEmailLog[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static RegistrationEmailLog[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static RegistrationEmailLog[]|Proxy[]                 findBy(array $attributes)
 * @method static RegistrationEmailLog[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static RegistrationEmailLog[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class RegistrationEmailLogFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'email_address' => self::faker()->email(),
            'email_body' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(RegistrationEmailLog $RegistrationEmailLog): void {})
        ;
    }

    protected static function getClass(): string
    {
        return RegistrationEmailLog::class;
    }
}
