{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Usuario" icon="la la-user-circle" :link="backpack_url('user')"/>
<x-backpack::menu-item title="Estudantes" icon="la la-users" :link="backpack_url('student')"/>
<x-backpack::menu-item title="Treinos" icon="la la-dumbbell" :link="backpack_url('training')"/>

<x-backpack::menu-item title="Agendamento" icon="la la-calendar" :link="backpack_url('schedule')"/>
<x-backpack::menu-item title="Plano Nutricional" icon="la la-apple" :link="backpack_url('nutritional-plan')"/>
<x-backpack::menu-item title="Presença" icon="la la-clock" :link="backpack_url('attendance')"/>
<x-backpack::menu-item title="Progresso de Treino" icon="la la-chart-line" :link="backpack_url('training-progress')"/>
