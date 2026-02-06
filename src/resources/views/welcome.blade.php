<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TODOリスト</title>

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                color-scheme: light;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: 'Inter', sans-serif;
                background: #f5f7fb;
                color: #111827;
            }

            .page {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 48px 20px;
            }

            .todo-app {
                width: min(880px, 100%);
                background: #fff;
                border-radius: 24px;
                box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
                padding: 40px;
                display: grid;
                gap: 32px;
            }

            .header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 24px;
                flex-wrap: wrap;
            }

            .title {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .title h1 {
                margin: 0;
                font-size: 2rem;
                font-weight: 700;
            }

            .title p {
                margin: 0;
                color: #6b7280;
                font-size: 0.95rem;
            }

            .stats {
                display: flex;
                gap: 16px;
                flex-wrap: wrap;
            }

            .stat-card {
                background: #f3f4f6;
                border-radius: 16px;
                padding: 12px 18px;
                min-width: 120px;
            }

            .stat-card span {
                display: block;
                font-size: 0.85rem;
                color: #6b7280;
            }

            .stat-card strong {
                font-size: 1.25rem;
            }

            .todo-form {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
                background: #f9fafb;
                border-radius: 16px;
                padding: 16px;
                border: 1px solid #e5e7eb;
            }

            .todo-form input[type="text"] {
                flex: 1;
                min-width: 220px;
                border: none;
                background: transparent;
                font-size: 1rem;
                outline: none;
            }

            .todo-form button {
                background: #2563eb;
                border: none;
                color: #fff;
                padding: 10px 18px;
                border-radius: 12px;
                font-weight: 600;
                cursor: pointer;
            }

            .todo-form button:disabled {
                background: #cbd5f5;
                cursor: not-allowed;
            }

            .filters {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }

            .filters button {
                border: 1px solid #e5e7eb;
                background: #fff;
                padding: 8px 14px;
                border-radius: 999px;
                font-size: 0.9rem;
                cursor: pointer;
            }

            .filters button.active {
                background: #111827;
                color: #fff;
                border-color: #111827;
            }

            .todo-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: grid;
                gap: 12px;
            }

            .todo-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 14px 16px;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                background: #fff;
            }

            .todo-item.completed {
                background: #f3f4f6;
                color: #6b7280;
            }

            .todo-item.completed .todo-text {
                text-decoration: line-through;
            }

            .todo-left {
                display: flex;
                align-items: center;
                gap: 12px;
                flex: 1;
            }

            .todo-left input[type="checkbox"] {
                width: 18px;
                height: 18px;
            }

            .todo-text {
                font-size: 1rem;
            }

            .todo-meta {
                font-size: 0.8rem;
                color: #9ca3af;
                margin-top: 4px;
            }

            .todo-actions button {
                border: none;
                background: #fee2e2;
                color: #991b1b;
                padding: 8px 12px;
                border-radius: 10px;
                cursor: pointer;
                font-size: 0.85rem;
            }

            .empty {
                text-align: center;
                padding: 40px 16px;
                border: 2px dashed #e5e7eb;
                border-radius: 20px;
                color: #9ca3af;
            }

            .footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 12px;
                font-size: 0.9rem;
                color: #6b7280;
            }

            .footer button {
                border: none;
                background: #f97316;
                color: #fff;
                padding: 8px 14px;
                border-radius: 12px;
                cursor: pointer;
                font-size: 0.85rem;
            }

            @media (max-width: 640px) {
                .todo-app {
                    padding: 24px;
                }

                .header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .stats {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <main class="page">
            <section class="todo-app">
                <header class="header">
                    <div class="title">
                        <h1>TODOリスト</h1>
                        <p>今日やることを整理して、完了したらチェックを入れましょう。</p>
                    </div>
                    <div class="stats">
                        <div class="stat-card">
                            <span>総タスク</span>
                            <strong id="total-count">0</strong>
                        </div>
                        <div class="stat-card">
                            <span>未完了</span>
                            <strong id="active-count">0</strong>
                        </div>
                        <div class="stat-card">
                            <span>完了</span>
                            <strong id="completed-count">0</strong>
                        </div>
                    </div>
                </header>

                <form class="todo-form" id="todo-form">
                    <input id="todo-input" type="text" placeholder="例：仕様書を確認する" maxlength="80" autocomplete="off" />
                    <button type="submit" id="add-button" disabled>追加</button>
                </form>

                <div class="filters" role="tablist">
                    <button type="button" data-filter="all" class="active">すべて</button>
                    <button type="button" data-filter="active">未完了</button>
                    <button type="button" data-filter="completed">完了</button>
                </div>

                <ul class="todo-list" id="todo-list"></ul>
                <div class="empty" id="empty-state">タスクがまだありません。上のフォームから追加してください。</div>

                <footer class="footer">
                    <span id="helper-text">ローカルストレージに保存されます。</span>
                    <button type="button" id="clear-completed">完了タスクを削除</button>
                </footer>
            </section>
        </main>

        <script>
            const STORAGE_KEY = 'todo-list-items';
            const form = document.getElementById('todo-form');
            const input = document.getElementById('todo-input');
            const addButton = document.getElementById('add-button');
            const list = document.getElementById('todo-list');
            const emptyState = document.getElementById('empty-state');
            const filterButtons = Array.from(document.querySelectorAll('.filters button'));
            const totalCount = document.getElementById('total-count');
            const activeCount = document.getElementById('active-count');
            const completedCount = document.getElementById('completed-count');
            const clearCompletedButton = document.getElementById('clear-completed');

            let todos = [];
            let currentFilter = 'all';

            const loadTodos = () => {
                try {
                    const saved = localStorage.getItem(STORAGE_KEY);
                    todos = saved ? JSON.parse(saved) : [];
                } catch (error) {
                    todos = [];
                }
            };

            const saveTodos = () => {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(todos));
            };

            const formatDate = (timestamp) => {
                const date = new Date(timestamp);
                return date.toLocaleString('ja-JP', {
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                });
            };

            const updateCounts = () => {
                const total = todos.length;
                const completed = todos.filter((todo) => todo.completed).length;
                totalCount.textContent = total;
                completedCount.textContent = completed;
                activeCount.textContent = total - completed;
            };

            const renderTodos = () => {
                list.innerHTML = '';
                const filtered = todos.filter((todo) => {
                    if (currentFilter === 'active') return !todo.completed;
                    if (currentFilter === 'completed') return todo.completed;
                    return true;
                });

                emptyState.style.display = filtered.length === 0 ? 'block' : 'none';

                filtered.forEach((todo) => {
                    const item = document.createElement('li');
                    item.className = `todo-item ${todo.completed ? 'completed' : ''}`;

                    const left = document.createElement('div');
                    left.className = 'todo-left';

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.checked = todo.completed;
                    checkbox.addEventListener('change', () => {
                        todo.completed = !todo.completed;
                        saveTodos();
                        updateCounts();
                        renderTodos();
                    });

                    const textWrap = document.createElement('div');

                    const text = document.createElement('div');
                    text.className = 'todo-text';
                    text.textContent = todo.text;

                    const meta = document.createElement('div');
                    meta.className = 'todo-meta';
                    meta.textContent = `追加: ${formatDate(todo.createdAt)}`;

                    textWrap.appendChild(text);
                    textWrap.appendChild(meta);

                    left.appendChild(checkbox);
                    left.appendChild(textWrap);

                    const actions = document.createElement('div');
                    actions.className = 'todo-actions';

                    const deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.textContent = '削除';
                    deleteButton.addEventListener('click', () => {
                        todos = todos.filter((item) => item.id !== todo.id);
                        saveTodos();
                        updateCounts();
                        renderTodos();
                    });

                    actions.appendChild(deleteButton);

                    item.appendChild(left);
                    item.appendChild(actions);

                    list.appendChild(item);
                });
            };

            const setFilter = (filter) => {
                currentFilter = filter;
                filterButtons.forEach((button) => {
                    button.classList.toggle('active', button.dataset.filter === filter);
                });
                renderTodos();
            };

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                const value = input.value.trim();
                if (!value) return;

                const newTodo = {
                    id: crypto.randomUUID(),
                    text: value,
                    completed: false,
                    createdAt: Date.now(),
                };

                todos.unshift(newTodo);
                input.value = '';
                addButton.disabled = true;
                saveTodos();
                updateCounts();
                renderTodos();
            });

            input.addEventListener('input', () => {
                addButton.disabled = input.value.trim().length === 0;
            });

            filterButtons.forEach((button) => {
                button.addEventListener('click', () => setFilter(button.dataset.filter));
            });

            clearCompletedButton.addEventListener('click', () => {
                todos = todos.filter((todo) => !todo.completed);
                saveTodos();
                updateCounts();
                renderTodos();
            });

            loadTodos();
            updateCounts();
            renderTodos();
        </script>
    </body>
</html>
