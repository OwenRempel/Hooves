export default function FormInput({ inputLabel, password_check, type: enumType, ...rest }) {
  const { name } = rest;
  const type = enumType.toLowerCase();
  

  return (
    <div className='inputItem'>
      {inputLabel && <label htmlFor={name}>{inputLabel || name}</label>}
      <input id={name} type={type} {...rest} />
    </div>
  );
}