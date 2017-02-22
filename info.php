<?php

class info {
    var $platform = "AWS";
    var $major = "1";
    var $minor = "10";
    var $revision = "6";
    var $sYear = "2016";

    public function getPrettyVersion() {
        return $this->platform."-".($this->minor=="0"?($this->revision=="0"?$this->major:($this->major.".0.".$this->revision)):($this->revision=="0"?($this->major.".".$this->minor):($this->major.".".$this->minor.".".$this->revision)));
    }

    public function getPrettyCopyright() {
        return "Copyright &copy; ".(date("Y")!=$this->sYear?$this->sYear."-".date("Y"):date("Y"))." George Hynes and TechyByte Logistics.";
    }
}

$info = new info;