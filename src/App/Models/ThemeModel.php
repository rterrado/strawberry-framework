<?php

namespace Kenjiefx\StrawberryFramework\App\Models;

class ThemeModel
{
    private string $name;
    private string $rawHTML;

    public function setName(
        string $name
        )
    {
        $this->name = $name;
    }

    public function setRawHTML(
        string $rawHTML
        )
    {
        $this->rawHTML = $rawHTML;
    }

    public function getRawHTML()
    {
        return $this->rawHTML;
    }

    public function getIndexPath()
    {
        return ROOT.'/theme/'.$this->name.'/index.php';
    }

}
