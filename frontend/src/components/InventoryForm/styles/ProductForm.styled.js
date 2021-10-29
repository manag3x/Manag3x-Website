import styled from "styled-components";


export const ProductFormStyled = styled.form`
    display: flex;
    justify-content: center;
    flex-direction: column;
    font-weight: 500;

    section {
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        flex-wrap: wrap;

        label {
            width: 45%;
        }
    }

    p {
        font-size: .9rem;
    }

    a {
        text-decoration: none;
    }

    @media(max-width: ${({theme}) => theme.mobile}) {
        section {
            flex-direction: column;

            label {
                width: 100%;
            }
        }

        label {
            width: 100%;
        }

        p {
            font-size: .8rem;
        }
    }
`