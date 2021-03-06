## 1.2.0
### Added
- Support 'date-time' format in StringValidatorFiller

## 1.1.0
### Added
- Implement DateValidatorFiller
- Implement DatetimeValidatorFiller

## 1.0.0
### Added
- Have dependency injections have setters for the default implementation
- AbstractEnumValidatorFiller
- DefaultFillerRepositoryFactory
- IValidatorFillerWithFillerRepository interface
### Changed
- Refactor ObjectValidatorFiller
- Refactor ArrayValidatorFiller
- setValueInjectionCollection to withIFillerRepository (immutable)

## 0.6.0
### Added
- Implement StringValidatorFiller

## 0.5.0
### Added
- Implement BooleanValidatorFiller

## 0.4.1
### Fixed
- Fix multipleOf when null at NumberValidatorFiller (#6)

## 0.4.0
### Added
- Support property value injection

## 0.3.0
### Added
- Implement ObjectValidatorFiller

## 0.2.0
### Added
- ArrayValidatorFiller
### Changed
- Filler now implements IFillerRepository interface

## 0.1.0
### Added
- IntegerValidatorFiller
- NumberValidatorFiller
- EnumValidatorFiller
