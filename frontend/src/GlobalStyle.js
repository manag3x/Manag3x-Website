import { createGlobalStyle } from 'styled-components';

export const GlobalStyle = createGlobalStyle`
    :root {
        --maxWidth: 1280px;
        --white: #fff;
        --black: #000000 //This is just a sample template, the other color variables can be specified as so
        --lightBlue: #;
        --midBlue: #;
        --darkBlue: #;
        --fontVeryLarge: 2.5rem;
        --fontLarge: 1.5rem;
        --fontMid: 1.2rem;
        --fontSmall: 1rem;
    }

    * {
        box-sizing: border-box;
        font-family: 'Abel', sans-serif;
    }

    body {
        margin: 0;
        padding: 0;

        h1 {
            font-size: 2rem;
            font-weight:600;
            color: var(--black);
        }

        h3 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        p {
            font-size: 1rem;
            color: var(--black)
        }
    }

`;