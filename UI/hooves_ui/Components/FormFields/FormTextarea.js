import style from '../../styles/form.module.css'

export default function FormTextarea({ textareaLabel, ...rest }) {
    const { name } = rest;
  
    return (
      <div className={style.inputItem}>
        <label htmlFor={name}>{textareaLabel || name}</label>
        <textarea id={name} {...rest} />
      </div>
    );
  }