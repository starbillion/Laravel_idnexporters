<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VideoUrl implements Rule
{
    /**
     * @var string
     */
    public $service;

    /**
     * @var string
     */
    private $serviceKey;

    /**
     * @var array
     */
    private $services = [
        'youtube' => '@^https?://(www\.)?(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^\"&?/]{11})@i',
        'vimeo'   => '@^https?://(www\.)?(player\.)?(vimeo\.com/)((channels/[A-z]+/)|(groups/[A-z]+/videos/)|(video/))?([0-9]+)@i',
    ];

    /**
     * Create a new instance VideoUrl.
     *
     * @param string $service
     */
    public function __construct($service = null)
    {
        $serviceKey = mb_strtolower($service);
        if (null !== $service && !isset($this->services[$serviceKey])) {
            throw new ComponentException(sprintf('"%s" is not a recognized video service.', $service));
        }
        $this->service    = $service;
        $this->serviceKey = mb_strtolower($service);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (isset($this->services[$this->serviceKey])) {
            return preg_match($this->services[$this->serviceKey], $value) > 0;
        }
        foreach ($this->services as $pattern) {
            if (0 === preg_match($pattern, $value)) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.videolink');
    }
}
