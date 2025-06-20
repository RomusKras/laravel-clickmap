
// Click Tracking Script
(function() {
    'use strict';

    // Configuration
    const ClickTracker = {
        // Default configuration
        config: {
            endpoint: 'https://your-api.com/track-clicks', // Change this to your API endpoint
            batchSize: 10, // Number of clicks to batch before sending
            sendInterval: 5000, // Send data every 5 seconds
            maxRetries: 3, // Maximum number of retry attempts
            retryDelay: 1000, // Delay between retries in milliseconds
            debug: false // Enable console logging
        },

        // Click data storage
        clickQueue: [],

        // Initialize the tracker
        init: function(customConfig = {}) {
            // Merge custom config with defaults
            this.config = { ...this.config, ...customConfig };

            // Add event listener for clicks
            document.addEventListener('click', this.handleClick.bind(this), true);

            // Set up periodic sending of batched data
            setInterval(() => {
                if (this.clickQueue.length > 0) {
                    this.sendBatch();
                }
            }, this.config.sendInterval);

            // Send data before page unload
            window.addEventListener('beforeunload', () => {
                if (this.clickQueue.length > 0) {
                    this.sendBatch(true);
                }
            });

            this.log('Click tracker initialized');
        },

        // Handle click events
        handleClick: function(event) {
            const clickData = {
                // Coordinates relative to viewport
                x: event.clientX,
                y: event.clientY,

                // Page coordinates (for scrolled pages)
                pageX: event.pageX,
                pageY: event.pageY,

                // Viewport dimensions
                viewportWidth: window.innerWidth,
                viewportHeight: window.innerHeight,

                // Timestamp
                timestamp: new Date().toISOString(),
                unixTime: Date.now(),

                // Page information
                url: window.location.href,
                pathname: window.location.pathname,
                hostname: window.location.hostname,

                // Target element information
                target: {
                    tagName: event.target.tagName,
                    id: event.target.id || null,
                    className: event.target.className || null,
                    text: event.target.textContent ? event.target.textContent.substring(0, 100) : null,
                    href: event.target.href || null
                },

                // Additional metadata
                userAgent: navigator.userAgent,
                screenResolution: {
                    width: screen.width,
                    height: screen.height
                },
                devicePixelRatio: window.devicePixelRatio || 1
            };

            // Add to queue
            this.clickQueue.push(clickData);

            this.log('Click tracked:', clickData);

            // Send immediately if batch size reached
            if (this.clickQueue.length >= this.config.batchSize) {
                this.sendBatch();
            }
        },

        // Send batch of clicks to server
        sendBatch: async function(synchronous = false) {
            if (this.clickQueue.length === 0) return;

            // Get current batch
            const batch = [...this.clickQueue];
            this.clickQueue = [];

            const payload = {
                clicks: batch,
                sessionId: this.getSessionId(),
                sentAt: new Date().toISOString()
            };

            try {
                if (synchronous) {
                    // Use sendBeacon for page unload
                    if (navigator.sendBeacon) {
                        const blob = new Blob([JSON.stringify(payload)], { type: 'application/json' });
                        navigator.sendBeacon(this.config.endpoint, blob);
                        this.log('Data sent via sendBeacon');
                    } else {
                        // Fallback to synchronous XHR
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', this.config.endpoint, false);
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.send(JSON.stringify(payload));
                    }
                } else {
                    // Async fetch with retries
                    await this.sendWithRetry(payload);
                }
            } catch (error) {
                this.log('Error sending data:', error);
                // Re-add failed batch to queue
                this.clickQueue.unshift(...batch);
            }
        },

        // Send data with retry logic
        sendWithRetry: async function(payload, attempt = 1) {
            try {
                const response = await fetch(this.config.endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Session-ID': this.getSessionId()
                    },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                this.log('Data sent successfully');
                return response;
            } catch (error) {
                if (attempt < this.config.maxRetries) {
                    this.log(`Retry attempt ${attempt} of ${this.config.maxRetries}`);
                    await this.delay(this.config.retryDelay * attempt);
                    return this.sendWithRetry(payload, attempt + 1);
                }
                throw error;
            }
        },

        // Get or create session ID
        getSessionId: function() {
            let sessionId = sessionStorage.getItem('clickTrackerSessionId');
            if (!sessionId) {
                sessionId = this.generateUUID();
                sessionStorage.setItem('clickTrackerSessionId', sessionId);
            }
            return sessionId;
        },

        // Generate UUID
        generateUUID: function() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        },

        // Utility delay function
        delay: function(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },

        // Logging utility
        log: function(...args) {
            if (this.config.debug) {
                console.log('[ClickTracker]', ...args);
            }
        },

        // Public API methods

        // Manually send current batch
        flush: function() {
            return this.sendBatch();
        },

        // Get current queue size
        getQueueSize: function() {
            return this.clickQueue.length;
        },

        // Update configuration
        updateConfig: function(newConfig) {
            this.config = { ...this.config, ...newConfig };
            this.log('Config updated:', this.config);
        },

        // Pause tracking
        pause: function() {
            document.removeEventListener('click', this.handleClick, true);
            this.log('Tracking paused');
        },

        // Resume tracking
        resume: function() {
            document.addEventListener('click', this.handleClick.bind(this), true);
            this.log('Tracking resumed');
        }
    };

    // Expose to global scope
    window.ClickTracker = ClickTracker;

    // Auto-initialize with default config if data attribute present
    if (document.currentScript && document.currentScript.dataset.autoInit) {
        const scriptConfig = {};

        // Parse config from data attributes
        if (document.currentScript.dataset.endpoint) {
            scriptConfig.endpoint = document.currentScript.dataset.endpoint;
        }
        if (document.currentScript.dataset.debug) {
            scriptConfig.debug = document.currentScript.dataset.debug === 'true';
        }
        if (document.currentScript.dataset.batchSize) {
            scriptConfig.batchSize = parseInt(document.currentScript.dataset.batchSize);
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                ClickTracker.init(scriptConfig);
            });
        } else {
            ClickTracker.init(scriptConfig);
        }
    }
})();

// Примеры использования:
/*
// Ручная инициализация с пользовательской конфигурацией
ClickTracker.init({
    endpoint: 'https://your-api.com/track-clicks',
    debug: true,
    batchSize: 5,
    sendInterval: 10000
});

// Автоматическая инициализация через тег <script>
<script src="click-tracker.js"
        data-auto-init="true"
        data-endpoint="https://your-api.com/track-clicks"
        data-debug="true"
        data-batch-size="5">
</script>

// API методы
ClickTracker.flush(); // Вручную отправить текущую пачку данных
ClickTracker.pause(); // Приостановить отслеживание кликов
ClickTracker.resume(); // Возобновить отслеживание кликов
ClickTracker.getQueueSize(); // Получить количество кликов в очереди
ClickTracker.updateConfig({ debug: false }); // Обновить конфигурацию трекера (например, выключить режим отладки)
*/

