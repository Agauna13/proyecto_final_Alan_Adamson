
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                bernier: ['Bernier', 'sans-serif'],
            },
            keyframes: {
                slideInFromLeft: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateX(-100%)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateX(0)',
                    },
                },
                slideInFromRight: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateX(100%)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateX(0)',
                    },
                },
                slideInFromTop: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(-100%)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)',
                    },
                },
            },
            animation: {
                slideInFromLeft: 'slideInFromLeft 1s ease-out forwards',
                slideInFromRight: 'slideInFromRight 1s ease-out forwards',
                slideInFromTop: 'slideInFromTop 1s ease-out forwards',
            },
        },
    },
    plugins: [],
};
