# Training Module — Skill Reference

## 1. Module Overview

| | |
|---|---|
| **Name** | `Training` (declared in `module.json`) |
| **Namespace** | `Module\Training` |
| **Composer package** | `monosoft/module-training` |
| **PSR-4 mapping** | `Module\Training\` → `src/`, `ModuleTraining\Seeders\` → `database/seeders` |
| **Service provider** | `Module\Training\Providers\TrainingServiceProvider` (registered in `module.json` → `providers`) |
| **Connection** | `platform` (declared per-model as `protected $connection = 'platform'`) |
| **Style** | nwidart/laravel-modules module inside a modular monolith, part of a git-submodule tree under `modules/` |

**Purpose**: manages the full lifecycle of community/civic *training events* (Indonesian government/village context — "pelatihan"): scheduling training events, assigning committees (moderators/fellows/speakers), registering participants, tracking attendance/presence, running pre-test/post-test question banks with answers, printing rundowns/agenda, generating PDF-style reports, and administering per-user "training settings" (role assignment: ADMINISTRATOR vs OFFICER). It also maintains its own copies of subdistrict/village reference data scoped to training use, and read-only "history" views of finished events.

There is a sibling module `mytraining` (in `modules/mytraining`) which is presumably the self-service/officer-facing counterpart to this admin-facing `training` module (not analyzed here, but referenced by permission/ability names like `mytraining-speaker`).

## 2. Dependencies

### Composer (`composer.json`)
- `php: ^8.0.2`
- `guzzlehttp/guzzle: ^7.2`
- (Excel import/export via `maatwebsite/excel` is used in code — `src/Imports/DataImport.php`, seeders — but not declared in this module's own composer.json; it must be provided by the root application or another module.)

### Other modules (namespace references found in code)
| Module | Used for |
|---|---|
| `Module\System` | `Module\System\Traits\{HasMeta,Filterable,Searchable,HasPageSetup}` (mixed into every Training model), `Module\System\Models\SystemUser` (auth/policy user, `MorphOne` target for `user()` relations), `Module\System\Imports\BaseImport` (used by `TrainingBaseSeeder`) |
| `Module\Reference` | `Module\Reference\Models\ReferenceGender` (combo data for participant gender), `Module\Reference\Models\ReferenceRegency` (`belongsTo` on `TrainingSubdistrict`) |
| `Monoland\Platform` | `Monoland\Platform\DiscoverEvents` — platform-level helper used by `EventServiceProvider` to auto-discover event/listener pairs from `src/Listeners` |

No `src/Listeners` directory currently exists, so event discovery has nothing to find yet — `TrainingCommitteeUpdate` and `TrainingSettingUpdate` are dispatched but have no listeners defined inside this module (listeners likely live in `mytraining` or another consuming module, given ability names like `mytraining-speaker`).

## 3. Data Model / Schema

All tables live on the `platform` connection. Every table has `slug`, `meta` (jsonb), `softDeletes()`, and `timestamps()` unless noted.

| Table | Migration | Key columns | Notes |
|---|---|---|---|
| `training_events` | `2024_11_26_195245_create_training_events.php` | `name`, `slug` (unique), `startdate`, `finishdate`, `mode` enum(`LKD`,`DESA`), `village_id`, `subdistrict_id`, `regency_id`, `officer_id`, `workunit_id`, `status` enum(`DRAFTED`,`SUBMITTED`,`REPAIRED`,`REJECTED`,`ASSIGNED`,`PUBLISHED`,`CERTIFIED`,`COMPLETED`), `files` jsonb | Root aggregate — a training event/workshop |
| `training_participants` | `2024_11_26_195333_create_training_participants.php` | `name`, `slug` (unique), `mode` enum(`LKD`,`DESA`), `biodata_id`, `event_id`, `accepted_at` | Unique on (`biodata_id`,`event_id`); polymorphic `particiable_type`/`particiable_id` set at write time (member or official) though not in migration schema (likely added dynamically/JSON — see model) |
| `training_rundowns` | `2024_11_26_195540_create_training_rundowns.php` | `name`, `slug` (unique), `event_id`, `datemark`, `starttime`, `finishtime`, `agenda` (text), `speaker_id`, `speaker_name`, `files` | Agenda/schedule items for an event |
| `training_questions` | `2024_11_26_200015_create_training_questions.php` | `name` (text), `slug` (unique), `event_id`, `mode` enum(`PRETEST`,`POSTEST`), `options` jsonb, `answerkey` (1 char) | Question bank; same table serves both pretest & postest via `mode` |
| `training_answers` | `2024_11_26_200634_create_training_answers.php` | `event_id`, `participant_id`, `question_id`, `mode` enum(`PRETEST`,`POSTEST`), `answer` (1 char), `is_correct` bool, `answered_at` | Participant's submitted answers |
| `training_committees` | `2024_11_27_130335_create_training_committees.php` | `name`, `slug` (18 chars), `type` enum(`MODERATOR`,`FELLOW`,`SPEAKER`), `biodata_id`, `event_id` | Unique on (`biodata_id`,`event_id`) |
| `training_presences` | `2024_11_27_225018_create_training_presences.php` | `name`, `slug` (unique), `event_id`, `participant_id`, `datemark`, `timemark`, `validated_by`, `validated_at`, `files` | Attendance records |
| `training_settings` | `2025_02_28_144312_create_training_settings.php` | `name`, `slug` (unique, 18 chars), `role` enum(`ADMINISTRATOR`,`OFFICER`) | Grants a `SystemUser` a training role/license via slug matching |

**Tables referenced but owned by other modules** (models point at foreign tables):
- `TrainingBiodata` model → table `foundation_biodatas` (owned by `foundation` module)
- `TrainingMember` model → table `foundation_members`
- `TrainingOfficial` model → table `foundation_officials`
- `TrainingSubdistrict` / `TrainingVillage` — own tables not shown in this module's migrations (likely created elsewhere or shared with `reference`), but exposed here as Training-scoped Eloquent models with `regency_id`/`district_id` columns and `regency()` / `villages()` relations.

### Relationships (Eloquent, from `src/Models`)
- `TrainingEvent` **hasMany** `committees` (`TrainingCommittee`), `participants` (`TrainingParticipant`), `presences` (`TrainingPresence`), `rundowns` (`TrainingRundown`); **belongsTo** `subdistrict` (`TrainingSubdistrict`), `village` (`TrainingVillage`).
- `TrainingParticipant` **belongsTo** `event`, `subdistrict`, `village`.
- `TrainingCommittee` **morphOne** `user` → `SystemUser` (`userable`).
- `TrainingSetting` **morphOne** `user` → `SystemUser` (`userable`).
- `TrainingSubdistrict` **belongsTo** `regency` (`ReferenceRegency`), **hasMany** `villages` (`TrainingVillage`).
- `TrainingHistoryEvent` duplicates `TrainingEvent`'s schema/relations but is a separate model bound to the same `training_events` table, used for the read-only "history" (REJECTED/COMPLETED) views.

## 4. Domain Entities / Models (`src/Models`)

| Model | Table | Purpose |
|---|---|---|
| `TrainingEvent` | `training_events` | Core aggregate: a training event, its status workflow, location, mode |
| `TrainingHistoryEvent` | `training_events` | Same table, alternate model for the "history" (finished/rejected) section of the UI |
| `TrainingParticipant` | `training_participants` | A person registered/attending a specific event |
| `TrainingCommittee` | `training_committees` | Moderator/Fellow/Speaker assigned to an event |
| `TrainingRundown` | `training_rundowns` | Agenda item/session within an event |
| `TrainingQuestion` | `training_questions` | Pretest/postest question with options + answer key |
| `TrainingAnswer` | `training_answers` | A participant's answer to a question |
| `TrainingPresence` | `training_presences` | Attendance/presence record |
| `TrainingSetting` | `training_settings` | Maps a person (by slug) to a training role/license (ADMINISTRATOR/OFFICER) |
| `TrainingBiodata` | `foundation_biodatas` | Person identity data, shared with `foundation` module |
| `TrainingMember` | `foundation_members` | LKD-mode participant source (community member) |
| `TrainingOfficial` | `foundation_officials` | DESA-mode participant source (village official) |
| `TrainingSubdistrict` | (own table) | Subdistrict (kecamatan) reference, scoped for training |
| `TrainingVillage` | (own table) | Village (desa) reference, scoped for training |

### Conventions common to nearly every model
- Traits: `Filterable`, `HasMeta`, `HasPageSetup`, `Searchable`, `SoftDeletes` (all from `Module\System\Traits`).
- `protected $connection = 'platform'`.
- `protected $casts = ['meta' => 'array']` (plus date casts on `TrainingEvent`/`TrainingHistoryEvent`).
- `protected $roles = ['training-<entity>']` — used by `HasPageSetup`/permission helpers (`getPageIcon`, `getPageTitle`, `hasSoftDeleted`, etc).
- Static "map*" methods used to build the front-end contract, called from Resources' `with()`:
  - `mapCombos()` — dropdown/select data for forms
  - `mapHeaders()` — Vuetify-style data-table column defs
  - `mapResource()` / `mapResourceShow()` — flattening for list vs detail views
  - `mapRecordBase()` — default/blank record shape for "create" forms
  - `mapStatuses()` — computed permission/UI-state flags (`canCreate`, `canEdit`, `canDelete`, etc.), often gated by `$request->user()->hasLicenseAs(...)`
- CRUD is implemented as **static methods on the model itself** rather than in controllers/services: `storeRecord()`, `updateRecord()`, `deleteRecord()`, `restoreRecord()`, `destroyRecord()` (and custom transition methods like `assignedRecord()`, `completedRecord()`, `publishedRecord()`, `rejectedRecord()`, `submissionRecord()` on `TrainingEvent`). Each wraps a DB transaction on the `platform` connection and returns either a JsonResource or a `500` JSON error response inline.
- `TrainingEvent` status workflow (state machine driven by these methods + `TrainingEventPolicy`):
  `DRAFTED → SUBMITTED → (REPAIRED|REJECTED|ASSIGNED) → PUBLISHED → CERTIFIED/COMPLETED`
  - `submission` (officer/administrator, from DRAFTED/REPAIRED) → `SUBMITTED`
  - `assigned` (officer, from SUBMITTED) → `ASSIGNED`
  - `rejected` (officer, from SUBMITTED) → `REJECTED`
  - `published` (administrator, from ASSIGNED) → `PUBLISHED`
  - `completed` (administrator, from PUBLISHED) → `COMPLETED`
  - `scopeOnlyActive` excludes `REJECTED`/`COMPLETED`; `scopeOnlyHistory` includes only those two (drives the `event` vs `history` route/controller split).

## 5. API Routes (`routes/api.php`)

Mounted by `RouteServiceProvider::mapApiRoutes()` under `{prefix}/api`, middleware `['api', 'auth:sanctum']`, controller namespace `Module\Training\Http\Controllers`. Prefix/domain are resolved dynamically at boot from `system_modules` table (`slug = 'training'`), cached via `Cache::flexible`.

| Route | Controller | Notes |
|---|---|---|
| `GET dashboard` | `DashboardController@index` | Currently a stub (returns void) |
| `GET report` | `DashboardController@report` | Returns setup/combo JSON if no `type`, else renders a Blade report view |
| `POST event/{trainingEvent}/assigned` | `TrainingEventController@assigned` | Status transition |
| `POST event/{trainingEvent}/completed` | `TrainingEventController@completed` | Status transition |
| `POST event/{trainingEvent}/published` | `TrainingEventController@published` | Status transition |
| `POST event/{trainingEvent}/rejected` | `TrainingEventController@rejected` | Status transition |
| `POST event/{trainingEvent}/submission` | `TrainingEventController@submission` | Status transition |
| `resource event` | `TrainingEventController` | Full CRUD + soft-delete restore/forceDelete (route param renamed to `trainingEvent`) |
| `resource event.participant` | `TrainingParticipantController` | Nested under event |
| `resource event.committee` | `TrainingCommitteeController` | Nested under event |
| `resource event.rundown` | `TrainingRundownController` | Nested under event |
| `resource event.pretest` | `TrainingPretestController` | Nested under event; param `pretest` mapped to `trainingQuestion` |
| `resource event.postest` | `TrainingPostestController` | Nested under event; param `postest` mapped to `trainingQuestion` |
| `resource event.presence` | `TrainingPresenceController` | Nested under event |
| `resource history` | `TrainingHistoryController` | Same shape as `event` but for finished/rejected events (`onlyHistory` scope) |
| `resource history.participant` | `TrainingHistoryParticipantController` | |
| `resource history.committee` | `TrainingHistoryCommitteeController` | |
| `resource history.rundown` | `TrainingHistoryRundownController` | |
| `resource history.pretest` | `TrainingHistoryPretestController` | |
| `resource history.postest` | `TrainingHistoryPostestController` | |
| `resource history.presence` | `TrainingHistoryPresenceController` | |
| `GET subdistrict/{trainingSubdistrict}/villages` | `TrainingSubdistrictController@villages` | Combo data for a subdistrict's villages |
| `resource subdistrict` | `TrainingSubdistrictController` | |
| `GET village/{trainingVillage}/particiables` | `TrainingVillageController@particiables` | Combo of eligible participants (members/officials) for a village |
| `resource subdistrict.village` | `TrainingVillageController` | Nested under subdistrict |
| `resource setting` | `TrainingSettingController` | Training role/license administration |

Additional controllers exist without explicit routes wired in `api.php` (likely invoked internally or via a routes file not fully enumerated, or dead/in-progress code): `TrainingAnswerController`, `TrainingBiodataController`, `TrainingMemberController`, `TrainingOfficialController`, `TrainingQuestionController`, `TrainingRatingController`.

All standard resource controllers follow the same pattern seen in `TrainingEventController`/`TrainingSubdistrictController`: `Gate::authorize(...)` per action, delegate persistence to the model's static `*Record` methods, return `*Collection`/`*ShowResource` classes.

No `routes/web.php` exists yet — `mapWebRoutes()` in `RouteServiceProvider` is fully commented out.

## 6. Services / Business Logic Components

This module has **no dedicated `Services/` or `Repositories/` directory** — business logic lives directly on the Eloquent models (`storeRecord`, `updateRecord`, status-transition methods, `mapResource`/`mapCombos` etc.) and is invoked from thin controllers. This is the dominant convention across the module.

- `src/Imports/DataImport.php` — `Module\Training\Imports\DataImport implements WithMultipleSheets, WithChunkReading` (Laravel Excel). Used by `TrainingDataSeeder` to bulk-import `database/masters/data-seeder.xlsx` (chunk size 5000). Sheets are injected via constructor, empty by default.
- `database/masters/base-seeder.xlsx` — master reference data imported via `Module\System\Imports\BaseImport` in `TrainingBaseSeeder`.

## 7. Policies / Permissions (`src/Policies`)

One policy class per model, matching the naming convention `Module\Training\Policies\{Model}Policy` — auto-resolved via a custom `Gate::guessPolicyNamesUsing` closure registered in `TrainingServiceProvider::boot()`:
```php
Gate::guessPolicyNamesUsing(fn($modelClass) =>
    str($modelClass)->before('\\Models\\') . '\\Policies\\' . str($modelClass)->after('\\Models\\') . 'Policy'
);
```

| Policy | Guards |
|---|---|
| `TrainingEventPolicy` | `view`, `show`, `create`, `update`, `assigned`, `completed`, `published`, `rejected`, `submission`, `delete`, `restore`, `destroy` |
| `TrainingAnswerPolicy` | standard CRUD abilities |
| `TrainingBiodataPolicy` | standard CRUD abilities |
| `TrainingCommitteePolicy` | standard CRUD abilities |
| `TrainingMemberPolicy` | standard CRUD abilities |
| `TrainingOfficialPolicy` | standard CRUD abilities |
| `TrainingParticipantPolicy` | standard CRUD abilities |
| `TrainingPresencePolicy` | standard CRUD abilities |
| `TrainingQuestionPolicy` | standard CRUD abilities |
| `TrainingRundownPolicy` | standard CRUD abilities |
| `TrainingSettingPolicy` | standard CRUD abilities |
| `TrainingSubdistrictPolicy` | standard CRUD abilities |
| `TrainingVillagePolicy` | standard CRUD abilities |

**Authorization model** (from `TrainingEventPolicy`, representative of the pattern):
- `before()`: `SystemUser::hasLicenseAs('training-superadmin')` bypasses all checks.
- Fine-grained abilities combine a **license/role check** (`hasLicenseAs('training-administrator')` / `hasLicenseAs('training-officer')`) with a **permission string check** (`hasPermission('<verb>-training-<entity>')`, e.g. `create-training-event`, `update-training-event`, `delete-training-event`, `restore-training-event`, `destroy-training-event`) — permission naming is consistently `{action}-training-{entity-slug}` across all policies (verified: `create-training-answer`, `create-training-biodata`, `create-training-committee`, `create-training-event`, `create-training-member`, `create-training-official`, `create-training-participant`, `create-training-presence`, `create-training-question`, `create-training-rundown`, `create-training-setting`, `create-training-subdistrict`, `create-training-village`, plus matching `delete-*` set).
- Event status-transition abilities additionally check `$trainingEvent->status` (e.g. `published` requires status `ASSIGNED` and `training-administrator` license; `assigned`/`rejected` require status `SUBMITTED` and `training-officer` license).
- Licenses referenced: `training-superadmin`, `training-administrator`, `training-officer`.
- `TrainingUserSeeder` grants `training-superadmin` to the user whose email matches `env('ADMIN_EMAIL')`.

## 8. Events (`src/Events`)

| Event | Payload | Dispatched from |
|---|---|---|
| `TrainingCommitteeUpdate` | `Model $model`, `array $abilities` | `TrainingCommittee::storeRecord()` / `updateRecord()` — dispatched with ability `['training-moderator']`, `['mytraining-speaker']`, or `['training-fellow']` depending on committee `type` |
| `TrainingSettingUpdate` | `Model $model`, `array $abilities` | `TrainingSetting::storeRecord()` — dispatched with `['training-administrator']` or `['training-officer']` depending on `role`, only if `slug` is set |

Both are plain `Dispatchable`/`InteractsWithSockets`/`SerializesModels` events with no listeners inside this module. `EventServiceProvider` auto-discovers listeners from `src/Listeners` (directory does not currently exist) via `Monoland\Platform\DiscoverEvents`, and merges them into the app's central listener map — so listeners are expected to be added here or discovered from elsewhere as the module matures. The likely intent (based on ability names like `mytraining-speaker`) is that another module (e.g. `mytraining`) listens for these events to grant licenses/roles to the linked `SystemUser`.

## 9. Console Commands

`TrainingServiceProvider::discoverCommands()` scans `src/Commands` and auto-registers any class found there. **No `src/Commands` directory currently exists**, so no custom Artisan commands are registered by this module today (the mechanism is ready for future use).

## 10. Frontend Structure (`frontend/`)

Vue front-end mounted under Vue Router path `/training` (see `frontend/router/index.js`), lazy-loaded per route with webpack chunk name `training`. Root component `frontend/pages/Base.vue` (layout shell) with `requiredAuth: true` meta.

Route groups (each with an `index.vue` list wrapper and `crud/{create,edit,show,data}.vue` pages):
- `dashboard` (single page, no CRUD)
- `event` (+ nested: `event-committee`, `event-participant`, `event-postest`, `event-pretest`, `event-presence`, `event-rundown`)
- `history` (+ nested: `history-committee`, `history-participant`, `history-postest`, `history-pretest`, `history-presence`, `history-rundown`)
- `report` (single page)
- `setting` (CRUD)
- `subdistrict` (+ nested `subdistrict-village`)

This directly mirrors the API route structure in `routes/api.php` (event/*, history/*, subdistrict/*, setting).

### `resources/`
- `resources/views/welcome.blade.php` — default module placeholder view.
- `resources/views/reports/{css,event,participant}.blade.php` — Blade templates rendered by `DashboardController@report` for the "Daftar Peserta" (participant list) and "Daftar Pelatihan" (event list) printable reports, optionally filtered by subdistrict.
- `resources/flowchart/siruhay-training.bpmn` — BPMN process diagram documenting the training workflow (useful for understanding the intended business process/state machine visually).

### `database/masters/base-seeder.xlsx`
Master/reference data spreadsheet imported by `TrainingBaseSeeder` via `Module\System\Imports\BaseImport`.

## 11. Notable Patterns / Conventions

1. **"Fat model" CRUD**: no service/repository layer; controllers call `Gate::authorize()` then delegate straight to static model methods (`storeRecord`, `updateRecord`, `deleteRecord`, `restoreRecord`, `destroyRecord`) which handle the DB transaction and return a Resource or an inline `500` JSON error.
2. **Three-tier Resource classes per entity**: `{Entity}Resource` (list row), `{Entity}Collection` (wraps list + `with()` UI setup payload: combos/filters/headers/icon/key/recordBase/statuses/title/trashed/usetrash), `{Entity}ShowResource` (detail view, typically calls `mapResourceShow`).
3. **`HasPageSetup` trait** (from `Module\System\Traits`) is the backbone of the admin UI contract — provides `getPageIcon()`, `getPageTitle()`, `getDataKey()`, `hasSoftDeleted()`, and is paired with model-defined `mapHeaders/mapCombos/mapStatuses/mapRecordBase`.
4. **Event ↔ History duality**: nearly every "live" workflow entity has a mirrored "history" controller/route/frontend page reusing the *same* underlying model/table but filtered by `scopeOnlyActive`/`scopeOnlyHistory` (based on `status` field) — a soft split between "in progress" and "archived" views rather than separate tables.
5. **Polymorphic participant source**: `TrainingParticipant.mode` (`LKD` vs `DESA`) determines whether `particiable_type`/`particiable_id` points at `TrainingMember` (`foundation_members`) or `TrainingOfficial` (`foundation_officials`) — set explicitly in `storeRecord`/`updateRecord` rather than via Eloquent `morphTo()`.
6. **Slug-driven identity linking**: `TrainingCommittee` and `TrainingSetting` both resolve/create a shared `TrainingBiodata`/person record by `slug` (NIK or similar), then fire an update event carrying "ability" strings for another module/listener to sync `SystemUser` licenses.
7. **Consistent permission naming**: `{verb}-training-{entity}` (e.g. `create-training-event`, `delete-training-committee`) checked in every Policy, layered under license checks (`training-superadmin` > `training-administrator`/`training-officer`).
8. **Dynamic domain/prefix routing**: API routes are mounted using a domain/prefix resolved at runtime from the `system_modules` table (multi-tenant/multi-module routing pattern shared across this platform's modules).

## 12. How to Extend / Integrate

- **Add a new entity**: create migration in `database/migrations`, model in `src/Models` using the standard trait stack (`Filterable, HasMeta, HasPageSetup, Searchable, SoftDeletes`) + `connection = 'platform'` + `roles` array, matching `{Entity}Policy` in `src/Policies`, `{Entity}Resource`/`{Entity}Collection`/`{Entity}ShowResource` in `src/Http/Resources`, controller in `src/Http/Controllers` following the `Gate::authorize` + static-method-delegation pattern, then wire a `Route::resource(...)` in `routes/api.php` and a matching CRUD route group + Vue pages in `frontend/router/index.js` / `frontend/pages`.
- **Add a listener for `TrainingCommitteeUpdate` / `TrainingSettingUpdate`**: create `src/Listeners/{Name}.php`; `EventServiceProvider` auto-discovers it via `Monoland\Platform\DiscoverEvents` on next boot — no manual registration needed.
- **Add an Artisan command**: create `src/Commands/{Name}.php`; `TrainingServiceProvider::discoverCommands()` will pick it up automatically.
- **Grant access**: assign a `SystemUser` a license (`training-superadmin`, `training-administrator`, `training-officer`) via `SystemUser::addLicense(...)` (see `TrainingUserSeeder`), and ensure the corresponding `{verb}-training-{entity}` permission is granted for fine-grained gates to pass.
- **Cross-module coupling to be aware of**: this module reads/writes `foundation_biodatas`, `foundation_members`, `foundation_officials` (owned by `foundation` module) directly via Eloquent models pointed at those tables — changes to those schemas will break `TrainingBiodata`/`TrainingMember`/`TrainingOfficial`. It also depends on `Module\Reference\Models\ReferenceGender` and `ReferenceRegency`, and on `Module\System\Models\SystemUser` for auth/licensing.
- **Seeding**: `php artisan module:seed Training` runs `ModuleTraining\Seeders\DatabaseSeeder`, which itself calls `module:migrate` for Training, then `TrainingBaseSeeder` (master xlsx), `TrainingDataSeeder` (data xlsx), `TrainingUserSeeder` (grants superadmin license to `env('ADMIN_EMAIL')`).
