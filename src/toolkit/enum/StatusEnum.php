<?php

    namespace yiitk\enum;

    use yiitk\enum\base\BaseEnum;

    /**
     * Class BooleanEnum
     *
     * @property string $active
     * @property string $inactive
     * @property string $blocked
     * @property string $waitingConfirmation
     *
     * @property bool   $isActive
     * @property bool   $isInactive
     * @property bool   $isBlocked
     * @property bool   $isWaitingConfirmation
     *
     * @method static   active
     * @method static   inactive
     * @method static   blocked
     * @method static   waitingConfirmation
     */
    class StatusEnum extends BaseEnum
    {
        public const ACTIVE               = 'active';
        public const INACTIVE             = 'inactive';
        public const BLOCKED              = 'blocked';
        public const WAITING_CONFIRMATION = 'waiting_confirmation';

        /**
         * {@inheritdoc}
         */
        public static function defaultValue()
        {
            return self::INACTIVE;
        }

        /**
         * {@inheritdoc}
         */
        protected static function labels(): array
        {
            return [
                self::ACTIVE               => 'Active',
                self::INACTIVE             => 'Inactive',
                self::BLOCKED              => 'Blocked',
                self::WAITING_CONFIRMATION => 'Waiting Confirmation',
            ];
        }
    }
