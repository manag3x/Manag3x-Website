import styled from "styled-components";

export const InputElementStyled = styled.label`
    font-weight: 500;
    font-size: ${({theme}) => theme.fontMid};
    margin: 3px 0;
    width: 80%;
    cursor: pointer;

    input {
        background-color: ${({theme}) => theme.grey};
        border: none;
        border-radius: 2px;
        padding: 8px;
        margin: 5px 0;
        width: 100%;
        font-size: 12px;
        outline: none;
    }

    @media(max-width: ${({theme}) => theme.mobile}) {
        font-size: ${({theme}) => theme.fontSmall};
        margin: 2px 0;
    }

`

export const TextAreaElementStyled = styled.label`
    font-weight: 500;
    font-size: ${({theme}) => theme.fontMid};
    margin-top: 3px;
    width: 100%;

    textarea {
        background-color: ${({theme}) => theme.grey};
        border: none;
        border-radius: 2px;
        padding: 8px;
        margin-top: 5px;
        font-size: 12px;
        outline: none;
        resize: none;
        width: 100%;
    }

    @media(max-width: ${({theme}) => theme.mobile}) {
        font-size: ${({theme}) => theme.fontSmall};
        margin: 2px 0;
    }

`