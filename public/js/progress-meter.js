// Progress Meter JavaScript
class ProgressMeter {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.progressBar = this.container?.querySelector('.progress-bar');
        this.progressText = this.container?.querySelector('.progress-text');
        this.percentageElement = this.container?.querySelector('.progress-meter-percentage');
        
        if (this.container) {
            this.init();
        }
    }

    init() {
        // Add loaded class for entrance animation
        setTimeout(() => {
            this.container.classList.add('loaded');
        }, 100);

        // Get initial percentage from data attribute
        const targetPercentage = parseInt(this.container.dataset.percentage) || 0;
        
        // Start loading animation after a brief delay
        setTimeout(() => {
            this.animateProgress(targetPercentage);
        }, 500);
    }

    animateProgress(targetPercentage) {
        if (!this.progressBar) return;

        const progressContainer = this.progressBar.parentElement;
        
        // Add loading effect to container
        if (progressContainer) {
            progressContainer.classList.add('loading-active');
        }

        // Show loading text immediately
        if (this.progressText) {
            this.progressText.textContent = 'Memuat...';
            this.progressText.classList.add('visible');
            this.progressText.classList.add('progress-loading-text');
        }

        // Set CSS custom property for animation target
        this.progressBar.style.setProperty('--target-width', targetPercentage + '%');
        
        // Add loading class to trigger animation
        this.progressBar.classList.add('loading');
        
        // Animate percentage counter
        this.animateCounter(targetPercentage);
        
        // Remove loading effects after animation completes
        setTimeout(() => {
            this.progressBar.classList.remove('loading');
            if (progressContainer) {
                progressContainer.classList.remove('loading-active');
            }
            
            // Remove loading text class
            if (this.progressText) {
                this.progressText.classList.remove('progress-loading-text');
            }
            
            // Update color class based on percentage after loading
            this.updateProgressColor(targetPercentage);
        }, 1500);
        
        // Show percentage text inside bar if > 15% after loading animation
        setTimeout(() => {
            if (targetPercentage > 15 && this.progressText) {
                this.progressText.textContent = targetPercentage + '%';
                this.progressText.classList.add('visible');
            } else if (this.progressText) {
                this.progressText.classList.remove('visible');
            }
        }, 1600);
    }

    updateProgressColor(percentage) {
        if (!this.progressBar) return;

        // Remove existing color classes
        this.progressBar.classList.remove('danger', 'warning', 'info', 'success');
        
        // Add appropriate color class based on percentage
        if (percentage >= 100) {
            this.progressBar.classList.add('success');
        } else if (percentage >= 75) {
            this.progressBar.classList.add('info');
        } else if (percentage >= 50) {
            this.progressBar.classList.add('warning');
        } else {
            this.progressBar.classList.add('danger');
        }
    }

    animateCounter(targetPercentage) {
        if (!this.percentageElement) return;

        const statusIcon = this.percentageElement.querySelector('.status-icon');
        const percentageNumber = this.percentageElement.querySelector('.percentage-number');
        
        if (!percentageNumber) return;

        let currentPercentage = 0;
        const increment = targetPercentage / 60; // 60 frames for smooth animation
        
        const updateCounter = () => {
            currentPercentage += increment;
            
            if (currentPercentage >= targetPercentage) {
                currentPercentage = targetPercentage;
                percentageNumber.textContent = Math.round(currentPercentage) + '%';
                
                // Update status icon
                if (statusIcon) {
                    statusIcon.textContent = this.getStatusEmoji(currentPercentage);
                }
                return;
            }
            
            percentageNumber.textContent = Math.round(currentPercentage) + '%';
            
            // Update status icon during animation
            if (statusIcon) {
                statusIcon.textContent = this.getStatusEmoji(currentPercentage);
            }
            
            requestAnimationFrame(updateCounter);
        };
        
        requestAnimationFrame(updateCounter);
    }

    getStatusEmoji(percentage) {
        if (percentage >= 100) {
            return '✅'; // Green checkmark for 100%
        } else if (percentage >= 75) {
            return '🔵'; // Blue circle for 75-99%
        } else if (percentage >= 50) {
            return '🟡'; // Yellow circle for 50-74%
        } else {
            return '🔴'; // Red circle for 0-49%
        }
    }

    updateProgress(newPercentage) {
        // Method to update progress dynamically
        this.animateProgress(newPercentage);
        this.container.dataset.percentage = newPercentage;
    }
}

// Auto-initialize progress meters when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all progress meters on the page
    const progressMeterContainers = document.querySelectorAll('.progress-meter-container[id]');
    
    progressMeterContainers.forEach(container => {
        new ProgressMeter(container.id);
    });
});

// Global function to create new progress meter
window.createProgressMeter = function(containerId, percentage = 0) {
    const container = document.getElementById(containerId);
    if (container) {
        container.dataset.percentage = percentage;
        return new ProgressMeter(containerId);
    }
    return null;
};

// Function to update existing progress meter
window.updateProgressMeter = function(containerId, newPercentage) {
    const container = document.getElementById(containerId);
    if (container && container.progressMeterInstance) {
        container.progressMeterInstance.updateProgress(newPercentage);
    }
};

// Utility functions for real-time updates
window.ProgressMeterUtils = {
    // Format number with animations
    formatNumber: function(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    },
    
    // Calculate percentage
    calculatePercentage: function(completed, total) {
        if (total === 0) return 0;
        return Math.round((completed / total) * 100);
    },
    
    // Get status text based on percentage
    getStatusText: function(percentage) {
        if (percentage >= 100) {
            return 'Selesai';
        } else if (percentage >= 75) {
            return 'Hampir Selesai';
        } else if (percentage >= 50) {
            return 'Sedang Progress';
        } else {
            return 'Perlu Perhatian';
        }
    },
    
    // Get color class based on percentage
    getColorClass: function(percentage) {
        if (percentage >= 100) {
            return 'text-green-600 dark:text-green-400';
        } else if (percentage >= 75) {
            return 'text-blue-600 dark:text-blue-400';
        } else if (percentage >= 50) {
            return 'text-yellow-600 dark:text-yellow-400';
        } else {
            return 'text-red-600 dark:text-red-400';
        }
    }
};

// Real-time data fetching (optional - for future enhancement)
class ProgressDataManager {
    constructor(apiEndpoint) {
        this.apiEndpoint = apiEndpoint;
        this.progressMeters = new Map();
    }
    
    async fetchProgressData() {
        try {
            const response = await fetch(this.apiEndpoint);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching progress data:', error);
            return null;
        }
    }
    
    async updateAllMeters() {
        const data = await this.fetchProgressData();
        if (data) {
            this.progressMeters.forEach((meter, containerId) => {
                const percentage = ProgressMeterUtils.calculatePercentage(
                    data.completed, 
                    data.total
                );
                meter.updateProgress(percentage);
            });
        }
    }
    
    registerMeter(containerId, meter) {
        this.progressMeters.set(containerId, meter);
    }
}

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ProgressMeter, ProgressMeterUtils, ProgressDataManager };
}
