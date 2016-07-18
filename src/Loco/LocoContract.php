<?php

namespace Pixelpub\Loco;

interface LocoContract
{
    /**
     * @param $project
     * @param $language
     * @return mixed
     */
    public function fetch($project, $language);

    /**
     * @param $project
     * @return mixed
     */
    public function flush($project);
}
