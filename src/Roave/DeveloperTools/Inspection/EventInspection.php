<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Roave\DeveloperTools\Inspection;

use Roave\DeveloperTools\Stub\SerializableValueStub;
use Zend\EventManager\EventInterface;

/**
 * An inspection that contains data about an {@see \Zend\EventManager\EventInterface}
 */
class EventInspection implements InspectionInterface
{
    /**
     * @var string
     */
    private $eventId;

    /**
     * @var bool
     */
    private $isStart;

    /**
     * @var string
     */
    private $name;

    /**
     * @var SerializableValueStub
     */
    private $target;

    /**
     * @var SerializableValueStub
     */
    private $params;

    /**
     * @var bool
     */
    private $propagationIsStopped;

    /**
     * @var SerializableValueStub
     */
    private $trace;

    /**
     * @param string         $eventId
     * @param bool           $isStart
     * @param EventInterface $event
     */
    public function __construct(
        $eventId,
        $isStart,
        EventInterface $event
    ) {
        $this->eventId              = (string) $eventId;
        $this->isStart              = (bool) $isStart;
        $this->name                 = $event->getName();
        $this->target               = new SerializableValueStub($event->getTarget());
        $this->params               = new SerializableValueStub($event->getParams());
        $this->propagationIsStopped = (bool) $event->propagationIsStopped();
        $this->trace                = new SerializableValueStub(debug_backtrace());
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(get_object_vars($this));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        foreach (unserialize($serialized) as $var => $val) {
            $this->$var = $val;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return InspectionInterface[]
     */
    public function getInspectionData()
    {
        return [
            'eventId'              => $this->eventId,
            'isStart'              => $this->isStart,
            'name'                 => $this->name,
            'target'               => $this->target->getValue(),
            'params'               => $this->params->getValue(),
            'propagationIsStopped' => $this->propagationIsStopped,
            'trace'                => $this->trace->getValue(),
        ];
    }
}
