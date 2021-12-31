import style from '../../styles/form.module.css'

export default function FormCheckbox({ checkboxLabel, checkboxTitle, ...rest }) {
    const { name } = rest;
  
    return (
      <div className={style.inputItem}>
        <label htmlFor={name}> {checkboxLabel || name}</label>
          <span className={style.checkwrap}>
            <input id={name} type="checkbox" {...rest} /> <span className={style.checkboxtitle}>{checkboxTitle|| name}</span>
          </span> 
      </div>
    );
  }