<?php

    namespace yiitk\helpers;

    use DateTime;
    use DateTimeZone;
    use Yii;

    /**
     * Class DateTimeHelper
     */
    class DateTimeHelper extends DateTime
    {
        /**
         * {@inheritdoc}
         */
        public function __construct($time = null, $tz = null)
        {
            if (is_null($tz)) {
                $tz = new DateTimeZone(static::findCurrentTimeZone());
            }

            if ($time === null) {
                $time = 'now';
            }

            parent::__construct($time, $tz);
        }

        /**
         * @return string
         */
        public static function findCurrentTimeZone(): string
        {
            return Yii::$app->timeZone;
        }
    }
