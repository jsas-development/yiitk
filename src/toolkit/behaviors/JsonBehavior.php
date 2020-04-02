<?php

    namespace yiitk\behaviors;

    use yii\base\Behavior;
    use yii\db\ActiveRecord;

    /**
     * @property ActiveRecord $owner
     */
    class JsonBehavior extends Behavior
    {
        /**
         * @var array
         */
        public $attributes = [];

        /**
         * @var null|string
         */
        public $emptyValue;

        /**
         * @var bool
         */
        public $encodeBeforeValidation = true;

        /**
         * @inheritdoc
         */
        public function events()
        {
            return [
                ActiveRecord::EVENT_INIT            => function () {$this->initialization();},
                ActiveRecord::EVENT_AFTER_FIND      => function () {$this->decode();},
                ActiveRecord::EVENT_BEFORE_INSERT   => function () {$this->encode();},
                ActiveRecord::EVENT_BEFORE_UPDATE   => function () {$this->encode();},
                ActiveRecord::EVENT_AFTER_INSERT    => function () {$this->decode();},
                ActiveRecord::EVENT_AFTER_UPDATE    => function () {$this->decode();},
                ActiveRecord::EVENT_BEFORE_VALIDATE => function () {
                    if ($this->encodeBeforeValidation) {
                        $this->encodeValidate();
                    }
                },
                ActiveRecord::EVENT_AFTER_VALIDATE  => function () {
                    if ($this->encodeBeforeValidation) {
                        $this->decode();
                    }
                },
            ];
        }

        /**
         * @return void
         */
        protected function initialization(): void
        {
            foreach ($this->attributes as $attribute) {
                $this->owner->setAttribute($attribute, []);
            }
        }

        /**
         * @return void
         */
        protected function decode(): void
        {
            foreach ($this->attributes as $attribute) {
                $value = $this->owner->getAttribute($attribute);

                if (is_string($value)) {
                    $value = static::jsonDecode($value);
                }

                $this->owner->setAttribute($attribute, $value);
            }
        }

        /**
         * @return void
         */
        protected function encode(): void
        {
            foreach ($this->attributes as $attribute) {
                $value = $this->owner->getAttribute($attribute);

                if (is_null($value) || empty($value)) {
                    $value = $this->emptyValue;
                }

                $value = static::jsonEncode($value);

                $this->owner->setAttribute($attribute, (string)$value ?: $this->emptyValue);
            }
        }

        /**
         * @return void
         */
        protected function encodeValidate()
        {
            $this->encode();
        }

        /**
         * @param $value
         *
         * @return string|null
         */
        public static function jsonEncode($value)
        {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            } else {
                $value = null;
            }

            if ($value === false) {
                $value = null;
            }

            return $value;
        }

        /**
         * @param string $value
         *
         * @return array|object|null
         */
        public static function jsonDecode($value)
        {
            if (is_string($value)) {
                $value = json_decode($value, true);
            }

            if (is_array($value) || is_object($value)) {
                return $value;
            }

            return null;
        }
    }
