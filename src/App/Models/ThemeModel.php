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
        return $this;
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
        return $this->getThemeDir().'/index.php';
    }

    public function getThemeDir()
    {
        return ROOT.'/theme/'.$this->name;
    }

}
