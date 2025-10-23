<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SmartCBT</title>
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #3b82f6;
            --lighter-blue: #dbeafe;
            --dark-blue: #1e40af;
            --white: #ffffff;
            --gray-light: #f8fafc;
            --gray-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --success-green: #10b981;
            --warning-orange: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--lighter-blue) 0%, var(--primary-blue) 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            background: var(--white);
            border-radius: 15px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .welcome-section h1 {
            color: var(--primary-blue);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .welcome-section p {
            color: var(--text-light);
            font-size: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 1.2rem;
        }

        .logout-btn {
            background: var(--white);
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: var(--primary-blue);
            color: var(--white);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: var(--lighter-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
            color: var(--primary-blue);
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
        }

        .section-title {
            color: var(--primary-blue);
            font-size: 1.4rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--primary-blue);
            border-radius: 2px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-card {
            background: var(--gray-light);
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 20px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
            text-align: center;
        }

        .action-card:hover {
            border-color: var(--primary-blue);
            background: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
        }

        .action-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-blue);
        }

        .action-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .action-desc {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* Recent Activity */
        .recent-activity {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-border);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: var(--lighter-blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .activity-time {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .activity-score {
            background: var(--success-green);
            color: var(--white);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .user-info {
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-container {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 20px;
            }

            .welcome-section h1 {
                font-size: 1.5rem;
            }

            .stat-card {
                padding: 20px;
            }

            .quick-actions,
            .recent-activity {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <div class="welcome-section">
                <h1>Welcome, {{ auth()->user()->name }}</h1>
                <p>This is your SmartCBT learning dashboard</p>
            </div>
            <div class="user-info">
                <div class="user-avatar">RD</div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-number">12</div>
                <div class="stat-label">Tests Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-number">85%</div>
                <div class="stat-label">Average Score</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏱️</div>
                <div class="stat-number">5h 30m</div>
                <div class="stat-label">Study Time</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📈</div>
                <div class="stat-number">3</div>
                <div class="stat-label">Active Courses</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <div class="actions-grid">
                <a href="#" class="action-card">
                    <div class="action-icon">🧪</div>
                    <div class="action-title">Take a Test</div>
                    <div class="action-desc">Start a new assessment</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">📚</div>
                    <div class="action-title">Study Materials</div>
                    <div class="action-desc">Access learning resources</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">📋</div>
                    <div class="action-title">My Results</div>
                    <div class="action-desc">View test history</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">🎯</div>
                    <div class="action-title">Progress</div>
                    <div class="action-desc">Track your learning</div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="section-title">Recent Activity</h2>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-title">Mathematics Quiz</div>
                        <div class="activity-time">Completed 2 hours ago</div>
                    </div>
                    <div class="activity-score">92%</div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-title">Science Assessment</div>
                        <div class="activity-time">Completed yesterday</div>
                    </div>
                    <div class="activity-score">78%</div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">📖</div>
                    <div class="activity-content">
                        <div class="activity-title">English Literature</div>
                        <div class="activity-time">Studied 2 days ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-title">History Test</div>
                        <div class="activity-time">Completed 3 days ago</div>
                    </div>
                    <div class="activity-score">85%</div>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>
