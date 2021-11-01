import { InputElementStyled, TextAreaElementStyled } from "./styles/InputElement.styled";

export function InputElement (props) {

    return (
        <InputElementStyled>
            {props.display}
            <input name={props.name} type={props.type} id={props.for} onChange={props.handleChange}/>
        </InputElementStyled>
    )
}

export function TextAreaElement (props) {
    return (
        <TextAreaElementStyled>
            {props.display}
            <textarea name={props.name} id={props.for} rows="5" onChange={props.handleChange}></textarea>
        </TextAreaElementStyled>
    )
}
