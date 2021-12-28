import style from '../../styles/form.module.css'
export default function FormInput({ inputLabel, type: enumType, ...rest }) {
  const { name } = rest;
  const type = enumType.toLowerCase();

  return (
    <div className={style.inputItem}>
      {inputLabel && <label htmlFor={name}>{inputLabel || name}</label>}
      <input id={name} type={type} {...rest} />
    </div>
  );
}