<?php
 namespace MailPoetVendor\Symfony\Component\Validator\Mapping; if (!defined('ABSPATH')) exit; use MailPoetVendor\Symfony\Component\Validator\Constraint; use MailPoetVendor\Symfony\Component\Validator\Constraints\GroupSequence; use MailPoetVendor\Symfony\Component\Validator\Constraints\Traverse; use MailPoetVendor\Symfony\Component\Validator\Exception\ConstraintDefinitionException; use MailPoetVendor\Symfony\Component\Validator\Exception\GroupDefinitionException; class ClassMetadata extends \MailPoetVendor\Symfony\Component\Validator\Mapping\GenericMetadata implements \MailPoetVendor\Symfony\Component\Validator\Mapping\ClassMetadataInterface { public $name; public $defaultGroup; public $members = []; public $properties = []; public $getters = []; public $groupSequence = []; public $groupSequenceProvider = \false; public $traversalStrategy = \MailPoetVendor\Symfony\Component\Validator\Mapping\TraversalStrategy::IMPLICIT; private $reflClass; public function __construct($class) { $this->name = $class; if (\false !== ($nsSep = \strrpos($class, '\\'))) { $this->defaultGroup = \substr($class, $nsSep + 1); } else { $this->defaultGroup = $class; } } public function __sleep() { $parentProperties = parent::__sleep(); unset($parentProperties[\array_search('cascadingStrategy', $parentProperties)]); return \array_merge($parentProperties, ['getters', 'groupSequence', 'groupSequenceProvider', 'members', 'name', 'properties', 'defaultGroup']); } public function getClassName() { return $this->name; } public function getDefaultGroup() { return $this->defaultGroup; } public function addConstraint(\MailPoetVendor\Symfony\Component\Validator\Constraint $constraint) { if (!\in_array(\MailPoetVendor\Symfony\Component\Validator\Constraint::CLASS_CONSTRAINT, (array) $constraint->getTargets())) { throw new \MailPoetVendor\Symfony\Component\Validator\Exception\ConstraintDefinitionException(\sprintf('The constraint "%s" cannot be put on classes.', \get_class($constraint))); } if ($constraint instanceof \MailPoetVendor\Symfony\Component\Validator\Constraints\Traverse) { if ($constraint->traverse) { $this->traversalStrategy = \MailPoetVendor\Symfony\Component\Validator\Mapping\TraversalStrategy::TRAVERSE; } else { $this->traversalStrategy = \MailPoetVendor\Symfony\Component\Validator\Mapping\TraversalStrategy::NONE; } return $this; } $constraint->addImplicitGroupName($this->getDefaultGroup()); parent::addConstraint($constraint); return $this; } public function addPropertyConstraint($property, \MailPoetVendor\Symfony\Component\Validator\Constraint $constraint) { if (!isset($this->properties[$property])) { $this->properties[$property] = new \MailPoetVendor\Symfony\Component\Validator\Mapping\PropertyMetadata($this->getClassName(), $property); $this->addPropertyMetadata($this->properties[$property]); } $constraint->addImplicitGroupName($this->getDefaultGroup()); $this->properties[$property]->addConstraint($constraint); return $this; } public function addPropertyConstraints($property, array $constraints) { foreach ($constraints as $constraint) { $this->addPropertyConstraint($property, $constraint); } return $this; } public function addGetterConstraint($property, \MailPoetVendor\Symfony\Component\Validator\Constraint $constraint) { if (!isset($this->getters[$property])) { $this->getters[$property] = new \MailPoetVendor\Symfony\Component\Validator\Mapping\GetterMetadata($this->getClassName(), $property); $this->addPropertyMetadata($this->getters[$property]); } $constraint->addImplicitGroupName($this->getDefaultGroup()); $this->getters[$property]->addConstraint($constraint); return $this; } public function addGetterMethodConstraint($property, $method, \MailPoetVendor\Symfony\Component\Validator\Constraint $constraint) { if (!isset($this->getters[$property])) { $this->getters[$property] = new \MailPoetVendor\Symfony\Component\Validator\Mapping\GetterMetadata($this->getClassName(), $property, $method); $this->addPropertyMetadata($this->getters[$property]); } $constraint->addImplicitGroupName($this->getDefaultGroup()); $this->getters[$property]->addConstraint($constraint); return $this; } public function addGetterConstraints($property, array $constraints) { foreach ($constraints as $constraint) { $this->addGetterConstraint($property, $constraint); } return $this; } public function addGetterMethodConstraints($property, $method, array $constraints) { foreach ($constraints as $constraint) { $this->addGetterMethodConstraint($property, $method, $constraint); } return $this; } public function mergeConstraints(self $source) { if ($source->isGroupSequenceProvider()) { $this->setGroupSequenceProvider(\true); } foreach ($source->getConstraints() as $constraint) { $this->addConstraint(clone $constraint); } foreach ($source->getConstrainedProperties() as $property) { foreach ($source->getPropertyMetadata($property) as $member) { $member = clone $member; foreach ($member->getConstraints() as $constraint) { if (\in_array($constraint::DEFAULT_GROUP, $constraint->groups, \true)) { $member->constraintsByGroup[$this->getDefaultGroup()][] = $constraint; } $constraint->addImplicitGroupName($this->getDefaultGroup()); } $this->addPropertyMetadata($member); if ($member instanceof \MailPoetVendor\Symfony\Component\Validator\Mapping\MemberMetadata && !$member->isPrivate($this->name)) { $property = $member->getPropertyName(); if ($member instanceof \MailPoetVendor\Symfony\Component\Validator\Mapping\PropertyMetadata && !isset($this->properties[$property])) { $this->properties[$property] = $member; } elseif ($member instanceof \MailPoetVendor\Symfony\Component\Validator\Mapping\GetterMetadata && !isset($this->getters[$property])) { $this->getters[$property] = $member; } } } } } public function hasPropertyMetadata($property) { return \array_key_exists($property, $this->members); } public function getPropertyMetadata($property) { if (!isset($this->members[$property])) { return []; } return $this->members[$property]; } public function getConstrainedProperties() { return \array_keys($this->members); } public function setGroupSequence($groupSequence) { if ($this->isGroupSequenceProvider()) { throw new \MailPoetVendor\Symfony\Component\Validator\Exception\GroupDefinitionException('Defining a static group sequence is not allowed with a group sequence provider.'); } if (\is_array($groupSequence)) { $groupSequence = new \MailPoetVendor\Symfony\Component\Validator\Constraints\GroupSequence($groupSequence); } if (\in_array(\MailPoetVendor\Symfony\Component\Validator\Constraint::DEFAULT_GROUP, $groupSequence->groups, \true)) { throw new \MailPoetVendor\Symfony\Component\Validator\Exception\GroupDefinitionException(\sprintf('The group "%s" is not allowed in group sequences.', \MailPoetVendor\Symfony\Component\Validator\Constraint::DEFAULT_GROUP)); } if (!\in_array($this->getDefaultGroup(), $groupSequence->groups, \true)) { throw new \MailPoetVendor\Symfony\Component\Validator\Exception\GroupDefinitionException(\sprintf('The group "%s" is missing in the group sequence.', $this->getDefaultGroup())); } $this->groupSequence = $groupSequence; return $this; } public function hasGroupSequence() { return $this->groupSequence && \count($this->groupSequence->groups) > 0; } public function getGroupSequence() { return $this->groupSequence; } public function getReflectionClass() { if (!$this->reflClass) { $this->reflClass = new \ReflectionClass($this->getClassName()); } return $this->reflClass; } public function setGroupSequenceProvider($active) { if ($this->hasGroupSequence()) { throw new \MailPoetVendor\Symfony\Component\Validator\Exception\GroupDefinitionException('Defining a group sequence provider is not allowed with a static group sequence.'); } if (!$this->getReflectionClass()->implementsInterface('MailPoetVendor\\Symfony\\Component\\Validator\\GroupSequenceProviderInterface')) { throw new \MailPoetVendor\Symfony\Component\Validator\Exception\GroupDefinitionException(\sprintf('Class "%s" must implement GroupSequenceProviderInterface.', $this->name)); } $this->groupSequenceProvider = $active; } public function isGroupSequenceProvider() { return $this->groupSequenceProvider; } public function getCascadingStrategy() { return \MailPoetVendor\Symfony\Component\Validator\Mapping\CascadingStrategy::NONE; } private function addPropertyMetadata(\MailPoetVendor\Symfony\Component\Validator\Mapping\PropertyMetadataInterface $metadata) { $property = $metadata->getPropertyName(); $this->members[$property][] = $metadata; } } 