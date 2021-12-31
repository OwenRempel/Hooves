import style from '../../styles/form.module.css'

export default function FormSelect({ selectLabel, options, ...rest }) {
    const { name } = rest;
  
    if (!options) return null;
  
    return (
      <div className={style.inputItem}>
        <label htmlFor={name}>{selectLabel || name}</label>
        <select id={name} {...rest}>
          {options.map(({ option, ...opt }, index) => (
            <option key={index} {...opt}>
              {option}
            </option>
          ))}
        </select>
      </div>
    );
  }