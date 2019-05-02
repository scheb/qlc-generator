<?php

namespace Scheb\QlcGenerator\Qlc;

class Sequence extends QLCFunction {

    // active channels:
    // channel,value[,channel,value]...
    private $barSequenceSceneTemplate = <<<TPL
  <Function ID="%s" Type="Scene" Name="%s" Hidden="True">
   <Speed FadeIn="0" FadeOut="0" Duration="0"/>
   <FixtureVal ID="1">0,0,1,0,2,0,3,0,4,0,5,0,6,0,7,0,8,0,9,0,10,0,11,0,12,0,13,0,14,0,15,0,16,0,17,0,18,0,19,0,20,0,21,0,22,0,23,0</FixtureVal>
   <FixtureVal ID="2">0,0,1,0,2,0,3,0,4,0,5,0,6,0,7,0,8,0,9,0,10,0,11,0,12,0,13,0,14,0,15,0,16,0,17,0,18,0,19,0,20,0,21,0,22,0,23,0</FixtureVal>
  </Function>
TPL;

// connected to scene
    private $barSequenceTemplate = <<<TPL
  <Function ID="%s" Type="Sequence" Name="%s" Path="" BoundScene="%s">
   <Speed FadeIn="70" FadeOut="0" Duration="120"/>
   <Direction>Forward</Direction>
   <RunOrder>Loop</RunOrder>
   <SpeedModes FadeIn="PerStep" FadeOut="Default" Duration="PerStep"/>
%s  </Function>
TPL;

// device:channel,value[,channel,value]:device:...
    private $barStepTemplate = <<<TPL
   <Step Number="%s" FadeIn="%s" Hold="%s" FadeOut="%s" Values="52">%s</Step>
TPL;

    private $steps = [];
    private $name;
    private $sceneId;
    private $sequenceId;

    public function __construct($name)
    {
        $this->name = $name;
        $this->sceneId = self::nextId();
        $this->sequenceId = self::nextId();
    }

    public function addStep(array $deviceValues): void {
        $this->steps[] = $deviceValues;
    }

    public function generate(): string
    {
        $out = '';
        $out .= sprintf($this->barSequenceSceneTemplate, $this->sceneId, $this->name) . PHP_EOL;

        // 0:0,255,5,255:1:0,255:2:0,255
        $i = 0;
        $steps = '';
        foreach ($this->steps as $step) {
            $deviceValues = [];
            foreach ($step as $deviceId => $values) {
                $deviceChannelValues = [];
                foreach ($values as $channel => $value) {
                    $deviceChannelValues[] = $channel . ',' . $value;
                }
                $deviceValues[] = $deviceId . ':' . implode(',', $deviceChannelValues);
            }
            $stepValues = implode(':', $deviceValues);
            $steps .= sprintf($this->barStepTemplate, $i, 0, 100, 0, $stepValues) . PHP_EOL;
            ++$i;
        }

        $out .= sprintf($this->barSequenceTemplate, $this->sequenceId, $this->name, $this->sceneId, $steps) . PHP_EOL;

        return $out;
    }
}
