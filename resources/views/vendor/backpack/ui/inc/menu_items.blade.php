{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Students" icon="la la-question" :link="backpack_url('student')" />
<x-backpack::menu-item title="Trainings" icon="la la-question" :link="backpack_url('training')" />

<x-backpack::menu-item title="Schedules" icon="la la-question" :link="backpack_url('schedule')" />
<x-backpack::menu-item title="Nutritional plans" icon="la la-question" :link="backpack_url('nutritional-plan')" />
<x-backpack::menu-item title="Attendances" icon="la la-question" :link="backpack_url('attendance')" />
<x-backpack::menu-item title="Training progress" icon="la la-question" :link="backpack_url('training-progress')" />