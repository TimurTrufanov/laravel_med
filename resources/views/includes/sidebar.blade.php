<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="pt-3 nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('main.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>На головну</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('doctors.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-nurse"></i>
                        <p>Лікарі</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('calendar.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Календар прийомів</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('day-sheets.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-day"></i>
                        <p>Графік днів</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('time-sheets.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Робочі години</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('clinics.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-clinic-medical"></i>
                        <p>Клініки</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('specializations.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Спеціалізації</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('diagnoses.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-diagnoses"></i>
                        <p>Дігнози</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('analyses.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-vials"></i>
                        <p>Аналізи</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('services.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-sticky-note"></i>
                        <p>Послуги</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

